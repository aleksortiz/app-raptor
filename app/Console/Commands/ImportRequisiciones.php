<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Entrada;
use App\Models\RequisicionFactura;

class ImportRequisiciones extends Command
{
    protected $signature = 'requisiciones:import 
                            {path : Ruta absoluta del XLSX/CSV} 
                            {--year=25 : Sufijo de año a agregar al folio} 
                            {--simulate : No guarda en BD, solo muestra}';

    protected $description = 'Importa requisiciones (QUALITAS) desde un XLSX/CSV y crea App\Models\RequisicionFactura enlazando por Entrada->folio';

    /** @var array */
    protected $synonyms = [
        'folio_interno' => ['folio interno','folio','folioint'],
        'cliente'       => ['cliente'],
        'aseguradora'   => ['aseguradora'],
        'n_factura'     => ['n factura','no factura','factura','número de factura','numero de factura'],
        'vehiculo'      => ['vehiculo','vehículo','descripcion','descripción','concepto','reporte'],
        'mo'            => ['importe m.o','m.o','mo','mano de obra','importe mano de obra'],
        'refacc'        => ['importe refacc','refacc','refacciones','importe refacciones'],
        'iva'           => ['iva'],
        'total'         => ['total','importe','monto'],
        'fecha'         => ['fecha pago','fecha facturacion','fecha facturación','fecha'],
    ];

    /** @var array */
    protected $counters = [
        'processed' => 0,
        'created' => 0,
        'duplicates' => 0,
        'not_found' => 0,
        'skipped_non_qualitas' => 0,
        'skipped_no_folio' => 0,
        'errors' => 0,
    ];

    public function handle()
    {
        $path = (string) $this->argument('path');
        $yearSuffix = (string) $this->option('year') ?: '25';
        $simulate = (bool) $this->option('simulate');

        if (!is_file($path)) {
            $this->error("No se encontró el archivo: {$path}");
            return 1;
        }

        // 1) Leer datos (XLSX con Maatwebsite si está disponible; si falla, CSV)
        try {
            $rows = $this->readFileFlexible($path);
        } catch (\Throwable $e) {
            $this->error("Error leyendo el archivo: {$e->getMessage()}");
            return 1;
        }

        if (empty($rows)) {
            $this->warn('No se encontraron filas para procesar.');
            return 0;
        }

        // 2) Detectar fila de encabezados y mapa de columnas
        [$headerIndex, $colMap] = $this->detectHeaderAndMap($rows);
        if ($headerIndex === null) {
            $this->error('No fue posible detectar los encabezados (folio, cliente/aseguradora, etc.).');
            return 1;
        }

        // 3) Procesamiento fila por fila (solo QUALITAS)
        $this->line("Encabezados detectados en fila #".($headerIndex + 1).". Iniciando importación...\n");
        for ($i = $headerIndex + 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $this->counters['processed']++;

            $vals = $this->extractRowValues($row, $colMap);

            // Filtro QUALITAS
            $clienteTxt = $this->normalizeTxt($vals['cliente']);
            $asegTxt    = $this->normalizeTxt($vals['aseguradora']);
            $isQualitas = (Str::contains($clienteTxt, 'qualitas') || Str::contains($asegTxt, 'qualitas'));

            if (!$isQualitas) {
                $this->counters['skipped_non_qualitas']++;
                $this->comment("Fila ".($i+1).": Saltada (no es QUALITAS).");
                continue;
            }

            // Folio requerido
            $folioRaw = trim((string)($vals['folio_interno'] ?? ''));
            if ($folioRaw === '') {
                $this->counters['skipped_no_folio']++;
                $this->comment("Fila ".($i+1).": Saltada (sin FOLIO INTERNO).");
                continue;
            }

            $folio = $this->normalizeFolio($folioRaw, $yearSuffix);

            // Buscar Entrada por folio
            $entrada = Entrada::where('folio', $folio)->first();
            if (!$entrada) {
                $this->counters['not_found']++;
                $this->warn("Fila ".($i+1).": No se encontró Entrada con folio '{$folio}'.");
                continue;
            }

            // Idempotencia
            $exists = RequisicionFactura::where('model_type', Entrada::class)
                        ->where('model_id', $entrada->id)
                        ->exists();
            if ($exists) {
                $this->counters['duplicates']++;
                $this->info("Fila ".($i+1).": Duplicada (ya existe requisición para Entrada ID {$entrada->id}).");
                continue;
            }

            // Descripción preferente: VEHICULO | descripcion | concepto | reporte | fallback
            $descripcion = $vals['vehiculo'] ?: ($vals['descripcion'] ?? null);
            if (!$descripcion) {
                $descripcion = $vals['reporte'] ?: 'IMPORT QUALITAS';
            }

            // Monto: TOTAL | (MO+REFACC+IVA) | entrada->total
            $total = $this->parseMoney($vals['total']);
            if ($total === null || $total == 0.0) {
                $mo     = $this->parseMoney($vals['mo']);
                $refacc = $this->parseMoney($vals['refacc']);
                $iva    = $this->parseMoney($vals['iva']);
                $calc   = floatval($mo ?: 0) + floatval($refacc ?: 0) + floatval($iva ?: 0);
                $total  = $calc > 0 ? $calc : (float) ($entrada->total ?? 0);
            }

            // Numero de factura
            $numFactura = $vals['n_factura'] ?? null;

            // Fecha facturación
            $fechaFact = $this->parseDateFlexible($vals['fecha']);
            $fechaFactStr = $fechaFact ? $fechaFact->format('Y-m-d') : null;

            // Build payload
            $payload = [
                'cliente_id'        => $entrada->cliente_id,
                'model_id'          => $entrada->id,
                'model_type'        => Entrada::class,
                'uso_cfdi'          => null,
                'forma_pago'        => null,
                'descripcion'       => $this->cleanString($descripcion),
                'monto'             => $total,
                'aseguradora'       => 'QUALITAS',
                'numero_factura'    => $this->cleanString($numFactura),
                'fecha_facturacion' => $fechaFactStr,
                'fecha_pago'        => null,
            ];

            if ($simulate) {
                $this->line("SIMULATE Fila ".($i+1).": Crear RequisicionFactura para Entrada {$entrada->id} (folio {$folio}) | monto={$total} | factura=".($numFactura ?: 'N/A')." | fecha=".($fechaFactStr ?: 'N/A'));
                $this->counters['created']++; // Contamos como “creada” en simulación
            } else {
                try {
                    RequisicionFactura::create($payload);
                    $this->info("CREADA Fila ".($i+1).": RequisicionFactura para Entrada {$entrada->id} (folio {$folio}).");
                    $this->counters['created']++;
                } catch (\Throwable $e) {
                    $this->counters['errors']++;
                    $this->error("ERROR Fila ".($i+1).": {$e->getMessage()}");
                }
            }
        }

        // 4) Resumen
        $this->line("\n========== RESUMEN ==========");
        $this->line("Procesadas: {$this->counters['processed']}");
        $this->line("Creadas: {$this->counters['created']}");
        $this->line("Duplicadas: {$this->counters['duplicates']}");
        $this->line("Sin Entrada: {$this->counters['not_found']}");
        $this->line("Saltadas (no QUALITAS): {$this->counters['skipped_non_qualitas']}");
        $this->line("Saltadas (sin folio): {$this->counters['skipped_no_folio']}");
        $this->line("Errores: {$this->counters['errors']}");
        $this->line("=============================\n");

        return 0;
    }

    /* ======== Lectura de archivo ======== */

    /**
     * Lee el archivo de forma flexible.
     * 1) Si es .xlsx/.xls intenta con Maatwebsite\Excel (si existe); si falla, intenta con PhpSpreadsheet; si falla, error.
     * 2) Si es .csv intenta con delimitador coma; si detecta 1 columna, prueba con ; y luego con tab.
     * Devuelve un arreglo de filas (cada fila es un array indexado).
     */
    protected function readFileFlexible(string $path): array
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($ext, ['xlsx','xls'])) {
            // a) Maatwebsite\Excel
            if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
                try {
                    // Leemos TODAS las hojas; luego concatenamos filas.
                    $allSheets = \Maatwebsite\Excel\Facades\Excel::toArray(new class implements \Maatwebsite\Excel\Concerns\ToArray {
                        public function array(array $array) {}
                    }, $path);

                    // Opcional: intentar priorizar hoja "GUILLERMO VILLANUEVA 2025" con PhpSpreadsheet si está disponible
                    // pero, si no, usamos todas las hojas.
                    $rows = [];
                    foreach ($allSheets as $sheetRows) {
                        foreach ($sheetRows as $r) {
                            // Normalizamos a array de valores escalares
                            $rows[] = is_array($r) ? array_values($r) : [$r];
                        }
                    }
                    if (!empty($rows)) return $rows;
                } catch (\Throwable $e) {
                    // Continuar con PhpSpreadsheet
                }
            }

            // b) PhpSpreadsheet directo (si está disponible)
            if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($path);

                // Si existe la hoja “GUILLERMO VILLANUEVA 2025” úsala, si no, usa la primera
                $targetTitle = 'GUILLERMO VILLANUEVA 2025';
                $sheet = null;
                foreach ($spreadsheet->getAllSheets() as $ws) {
                    if (trim(Str::upper($ws->getTitle())) === Str::upper($targetTitle)) {
                        $sheet = $ws; break;
                    }
                }
                if ($sheet === null) {
                    $sheet = $spreadsheet->getSheet(0);
                }

                $rows = $sheet->toArray(null, true, true, true); // asociativo por columna (A,B,C,...)
                $linear = [];
                foreach ($rows as $row) {
                    $linear[] = array_values($row);
                }
                return $linear;
            }

            throw new \RuntimeException('No fue posible leer XLSX: instale maatwebsite/excel o phpoffice/phpspreadsheet, o convierta a CSV.');
        }

        // CSV
        return $this->readCsvFlexible($path);
    }

    protected function readCsvFlexible(string $path): array
    {
        $delims = [',',';',"\t"];
        foreach ($delims as $delim) {
            $rows = [];
            if (($h = fopen($path, 'r')) !== false) {
                while (($data = fgetcsv($h, 0, $delim)) !== false) {
                    // Limpia BOM y normaliza
                    if (isset($data[0])) {
                        $data[0] = $this->stripBom($data[0]);
                    }
                    $rows[] = $data;
                }
                fclose($h);
            }
            // Si con este delimitador tenemos más de 1 columna en la cabecera, lo damos por bueno
            if (!empty($rows) && count($rows[0]) > 1) {
                return $rows;
            }
        }
        // Último intento: devolver lo leído con coma
        if (($h = fopen($path, 'r')) !== false) {
            $rows = [];
            while (($data = fgetcsv($h)) !== false) {
                if (isset($data[0])) {
                    $data[0] = $this->stripBom($data[0]);
                }
                $rows[] = $data;
            }
            fclose($h);
            return $rows;
        }
        return [];
    }

    protected function stripBom(string $s): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $s) ?? $s;
    }

    /* ======== Detección de encabezados y mapeo ======== */

    /**
     * Devuelve [headerIndex, colMap].
     * colMap => ['folio_interno' => idx, 'cliente'=> idx, ...] (índices de columna en $rows)
     */
    protected function detectHeaderAndMap(array $rows): array
    {
        $bestIndex = null;
        $bestMap = [];
        $maxScore = -1;

        $limit = min(20, count($rows));
        for ($i = 0; $i < $limit; $i++) {
            $row = $rows[$i];
            $map = $this->buildColMap($row);
            $score = count($map);
            if ($score > $maxScore) {
                $maxScore = $score;
                $bestIndex = $i;
                $bestMap = $map;
            }
        }

        // Debemos tener al menos 3 columnas clave para considerarlo encabezado
        if ($maxScore < 3) {
            return [null, []];
        }

        return [$bestIndex, $bestMap];
    }

    protected function buildColMap(array $headerRow): array
    {
        $map = [];
        foreach ($headerRow as $idx => $raw) {
            $key = $this->normalizeHeader((string)$raw);
            if ($key === '') continue;

            foreach ($this->synonyms as $canon => $alts) {
                foreach ($alts as $alt) {
                    if ($key === $this->normalizeHeader($alt)) {
                        // Evitar colisiones, conservar primer match
                        if (!array_key_exists($canon, $map)) {
                            $map[$canon] = $idx;
                        }
                    }
                }
            }
        }

        // Alias prácticos: si 'vehiculo' no aparece pero sí 'descripcion'/'concepto' o 'reporte'
        // lo resolveremos al extraer fila.
        return $map;
    }

    protected function normalizeHeader(string $s): string
    {
        $s = Str::ascii($s);
        $s = Str::lower($s);
        $s = preg_replace('/[^a-z0-9]+/u', ' ', $s) ?? $s;
        $s = trim(preg_replace('/\s+/', ' ', $s) ?? $s);
        return $s;
    }

    protected function normalizeTxt(?string $s): string
    {
        $s = (string) $s;
        $s = Str::lower(Str::ascii($s));
        return trim($s);
    }

    protected function extractRowValues(array $row, array $map): array
    {
        $get = function(?int $idx) use ($row) {
            if ($idx === null) return null;
            return array_key_exists($idx, $row) ? (is_scalar($row[$idx]) ? trim((string)$row[$idx]) : null) : null;
        };

        $vals = [
            'folio_interno' => $get($map['folio_interno'] ?? null),
            'cliente'       => $get($map['cliente'] ?? null),
            'aseguradora'   => $get($map['aseguradora'] ?? null),
            'n_factura'     => $get($map['n_factura'] ?? null),
            'vehiculo'      => $get($map['vehiculo'] ?? null), // puede venir vacío y lo suplimos abajo
            'mo'            => $get($map['mo'] ?? null),
            'refacc'        => $get($map['refacc'] ?? null),
            'iva'           => $get($map['iva'] ?? null),
            'total'         => $get($map['total'] ?? null),
            'fecha'         => $get($map['fecha'] ?? null),
        ];

        // Si no hubo 'vehiculo', intenta con descripcion/concepto o reporte escaneando encabezados originales:
        if ($vals['vehiculo'] === null) {
            // Buscamos columnas potenciales por aproximación:
            $candidatos = ['descripcion','descripción','concepto','reporte'];
            foreach ($candidatos as $cand) {
                $idx = $this->findLooseColumnIndex($cand, $row, $map);
                if ($idx !== null) {
                    $vals['vehiculo'] = is_scalar($row[$idx]) ? trim((string)$row[$idx]) : null;
                    if ($vals['vehiculo']) break;
                }
            }
            // Para compatibilidad con preferencia en descripción, guardamos además 'descripcion' y 'reporte'
            $vals['descripcion'] = $vals['vehiculo'];
            $vals['reporte'] = null;
            if (!$vals['vehiculo']) {
                $idxRep = $this->findLooseColumnIndex('reporte', $row, $map);
                if ($idxRep !== null) {
                    $vals['reporte'] = is_scalar($row[$idxRep]) ? trim((string)$row[$idxRep]) : null;
                }
            }
        } else {
            // además intenta capturar 'reporte' por si vehiculo está vacío:
            $vals['descripcion'] = $vals['vehiculo'];
            $vals['reporte'] = null;
            $idxRep = $this->findLooseColumnIndex('reporte', $row, $map);
            if ($idxRep !== null) {
                $vals['reporte'] = is_scalar($row[$idxRep]) ? trim((string)$row[$idxRep]) : null;
            }
        }

        return $vals;
    }

    protected function findLooseColumnIndex(string $want, array $row, array $map): ?int
    {
        // Buscar en el header original más cercano (a partir del mapa ya hecho no tenemos textos),
        // así que hacemos un pequeño heurístico: si la fila es de datos, no hay encabezados aquí.
        // Este método solo se usa para recuperar 'reporte/descripcion/concepto' cuando no vino mapeado.
        return null; // mantenemos simple; el mapeo primario suele ser suficiente
    }

    /* ======== Normalización de folio y parsing ======== */

    protected function normalizeFolio(string $folioRaw, string $year): string
    {
        $folioRaw = trim($folioRaw);
        $folioRaw = Str::upper($folioRaw);

        // Quitar espacios
        $folioRaw = preg_replace('/\s+/', '', $folioRaw) ?? $folioRaw;

        // Si ya trae -YY al final, respeta
        if (preg_match('/^\d{2}-\d{2}-\d{2}$/', $folioRaw)) {
            return $folioRaw;
        }

        // Formato NN-NN -> NN-NN-YY
        if (preg_match('/^\d{2}-\d{2}$/', $folioRaw)) {
            return "{$folioRaw}-{$year}";
        }

        // Formato NNNN -> NN-NN-YY (3001 => 30-01-YY)
        if (preg_match('/^\d{4}$/', $folioRaw)) {
            $a = substr($folioRaw, 0, 2);
            $b = substr($folioRaw, 2, 2);
            return "{$a}-{$b}-{$year}";
        }

        // Si trae otro sufijo tipo -YYYY, convertir a -YY si coincide año?
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $folioRaw)) {
            // Mantener como viene, por instrucción de "si ya trae sufijo, respétalo"
            return $folioRaw;
        }

        // Intento de normalización suave: reemplazar cualquier separador por "-"
        $normalized = preg_replace('/[^0-9]+/', '-', $folioRaw) ?? $folioRaw;
        $normalized = trim($normalized, '-');

        if (preg_match('/^\d{2}-\d{2}$/', $normalized)) {
            return "{$normalized}-{$year}";
        }
        if (preg_match('/^\d{2}-\d{2}-\d{2}$/', $normalized) || preg_match('/^\d{2}-\d{2}-\d{4}$/', $normalized)) {
            return $normalized;
        }

        // Último recurso: devolver como viene
        return $folioRaw;
    }

    protected function parseMoney($value): ?float
    {
        if ($value === null || $value === '') return null;
        if (is_numeric($value)) return (float)$value;

        $s = (string)$value;
        $s = trim($s);

        // Quitar símbolos de moneda y espacios
        $s = preg_replace('/[^\d,.\-]/', '', $s) ?? $s;

        // Si hay coma y punto:
        $hasComma = strpos($s, ',') !== false;
        $hasDot   = strpos($s, '.') !== false;

        if ($hasComma && $hasDot) {
            // Usar el último separador como decimal
            $lastComma = strrpos($s, ',');
            $lastDot   = strrpos($s, '.');
            if ($lastComma > $lastDot) {
                // coma decimal: quita puntos (miles), cambia coma por punto
                $s = str_replace('.', '', $s);
                $s = str_replace(',', '.', $s);
            } else {
                // punto decimal: quita comas (miles)
                $s = str_replace(',', '', $s);
            }
        } elseif ($hasComma && !$hasDot) {
            // Asumir coma decimal
            $s = str_replace('.', '', $s); // por si hay puntos de miles
            $s = str_replace(',', '.', $s);
        } else {
            // Solo punto o solo números
            $s = str_replace(',', '', $s);
        }

        if ($s === '' || $s === '-' || $s === '.' || $s === '-.') return null;

        return is_numeric($s) ? (float)$s : null;
    }

    protected function parseDateFlexible($value): ?Carbon
    {
        if ($value === null || $value === '') return null;

        // Excel serial?
        if (is_numeric($value)) {
            $serial = (float)$value;
            // 25569 = 1970-01-01
            try {
                $timestamp = ($serial - 25569) * 86400;
                if ($timestamp > 0) {
                    return Carbon::createFromTimestampUTC((int)$timestamp);
                }
            } catch (\Throwable $e) {}
        }

        $s = trim((string)$value);

        // Intentos de formato comunes
        $formats = ['d/m/Y','d-m-Y','m/d/Y','m-d-Y','Y-m-d','Y/m/d','d.m.Y','Y.m.d','d M Y','M d, Y','d/m/y','d-m-y','Y-m-d H:i:s'];
        foreach ($formats as $fmt) {
            try {
                $dt = Carbon::createFromFormat($fmt, $s);
                if ($dt !== false) return $dt;
            } catch (\Throwable $e) {}
        }

        // Fallback parse libre
        try {
            return Carbon::parse($s);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function cleanString($v): ?string
    {
        if ($v === null) return null;
        $v = trim((string)$v);
        return $v === '' ? null : $v;
    }
}
