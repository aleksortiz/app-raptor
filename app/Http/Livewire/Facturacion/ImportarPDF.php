<?php

namespace App\Http\Livewire\Facturacion;

use App\Services\OpenAI\OpenAIClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Entrada;

class ImportarPDF extends Component
{
    use WithFileUploads;

    public $pdf; // UploadedFile
    public ?string $responseText = null;
    public bool $isLoading = false;
    public array $rows = [];

    protected function rules(): array
    {
        return [
            'pdf' => 'required|file|mimes:pdf|max:20480', // 20MB
        ];
    }

    public function render()
    {
        return view('livewire.facturacion.importar-pdf.view');
    }

    public function procesar(): void
    {
        $this->validate();

        $this->isLoading = true;
        $this->responseText = null;
        $this->rows = [];

        try {
            $client = new OpenAIClient();

            // 1) Subir el archivo PDF a OpenAI
            $upload = $client->uploadFile($this->pdf, 'assistants');
            $fileId = (string) ($upload['id'] ?? '');
            if ($fileId === '') {
                throw new \RuntimeException('No se obtuvo file_id al subir el PDF a OpenAI.');
            }

            // 2) Prompts del sistema y del usuario (hardcodeado)
            $systemPrompt = 'Eres un asistente que lee un archivo PDF y devuelve EXCLUSIVAMENTE un JSON válido siguiendo estrictamente el esquema indicado en el prompt del usuario. Si hay valores faltantes, usa null. No agregues comentarios ni explicaciones.';

            $userPrompt = <<<'PROMPT'
Se te proporciona un PDF en español con cortes/semanas de facturación (p. ej., “SEM 28”) que contiene filas con “FOLIO INTERNO”, cliente/aseguradora, número de factura (p. ej., “A2541”) y columnas monetarias (mano de obra, refacciones, IVA, TOTAL, etc.), además de una sección separada de pagos con fechas y referencias a facturas.

Objetivo: Extrae únicamente las filas de facturas y produce un arreglo JSON de objetos con EXACTAMENTE el siguiente esquema (y nada más en la salida):

[
  {
    "aseguradora": "QUALITAS" | "CENTAURO" | "PARTICULAR",
    "model_type": "App\\Models\\Entrada",
    "model_folio": "NN-NN-25",
    "numero_reporte": "111111111" | null,
    "numero_factura": "AXXXX",
    "monto": 0.00,
    "fecha_facturacion": null,
    "fecha_pago": null,
    "descripcion": "",
    "uso_cfdi": "G03",
    "forma_pago": "99"
  }
]

Reglas de mapeo:

1) aseguradora
   - Determina si la factura es para una aseguradora conocida (QUALITAS, CENTAURO) o PARTICULAR.
   - Si el texto indica una aseguradora (p. ej., QUALITAS, CENTAURO), usa exactamente ese valor en mayúsculas.
   - Si no hay mención clara de aseguradora, usa "PARTICULAR".

2) model_type
   - Siempre la cadena literal: App\Models\Entrada

3) model_folio (proviene de “FOLIO INTERNO”)
   - Extrae folios como 18-07, 28-11, etc.
   - Si el folio no incluye el año, agrega -25 (ej.: 18-07 → 18-07-25).
   - Si ya incluye -25, déjalo tal cual.
   - Si la fila no tiene folio interno, omite esa fila.

4) numero_reporte (fallback si no hay folio)
   - Si existe un "número de reporte" en el PDF, normalízalo a EXACTAMENTE 9 dígitos:
     • Elimina espacios, separadores y guiones internos.
     • Ignora una terminación tipo "-X" al final (una letra después de guion), si la hubiera.
     • Ej.: "111 111 111 - T" → "111111111".
   - Si tras normalizar no hay exactamente 9 dígitos, usa null.
   - Conserva este valor para permitir búsqueda en sistema cuando falte folio.

5) numero_factura
   - Extrae el número que empieza con “A” seguido de dígitos (p. ej., A2539, A2541). Mayúsculas y trim.
   - Si falta o es inválido, deja "numero_factura" como null.

6) monto
   - Usa la columna TOTAL de esa fila (no ABONO ni SALDO).
   - Convierte a número (float). Quita separadores de miles y usa . como separador decimal.
   - Ejemplo: $ 13,940.68 → 13940.68
   - Si falta TOTAL, intenta mano_obra + refacciones + IVA; si no se puede, omite esa fila.

7) fecha_facturacion
   - Si hay una fecha de emisión de la factura en la fila, conviértela a YYYY-MM-DD; si no, usa null.

8) fecha_pago
   - Busca en la sección de pagos (líneas como: QUALITAS 11/07/2025 ... SEM 28 A2539-A2540 24492332).
   - Si una línea menciona exactamente el número de factura de esta fila, establece "fecha_pago" con esa fecha en formato YYYY-MM-DD.
   - Si hay múltiples pagos para la misma factura, elige la fecha más temprana.
   - Si no hay pago, deja null.

9) descripcion
   - Texto breve útil para captura, máx. ~120 caracteres.
   - Sugerencia: "SEM XX - {numero_factura} - {cliente/aseguradora} - {folio}" si la información está disponible.

10) uso_cfdi
   - Usa "G03" por defecto salvo que el PDF indique claramente otro.

11) forma_pago
   - Usa "99" (Por definir) por defecto salvo que el PDF indique claramente otro código SAT.

Guía de parsing y restricciones:
* El PDF está en español; números usan $, separador de miles "," y separador decimal ".".
* Ignora totales generales, ABONO, SALDO, subtotales y agregados que no correspondan a una factura específica.
* Ignora otras hojas/bloques como históricos a menos que coincidan con la misma semana y tengan FOLIO INTERNO válido y TOTAL.
* Algunos renglones no alinean visualmente; apóyate en patrones:
  - FOLIO INTERNO: NN-NN o NN-NN-25
  - numero_factura: A + dígitos (si existe)
  - TOTAL: cifra monetaria más a la derecha del renglón principal
* Des-duplica por (model_folio, numero_factura). Si no hay numero_factura, des-duplica por model_folio.
* Fechas en el PDF están en DD/MM/YYYY. Convierte a YYYY-MM-DD.
* Devuelve únicamente el arreglo JSON con los objetos. Sin Markdown, sin comentarios, sin fences.

Validación:
* Asegúrate que cada objeto contenga todas las llaves anteriores con tipos correctos:
  - aseguradora: string
  - model_type: string
  - model_folio: string
  - numero_reporte: string (9 dígitos) o null
  - numero_factura: string o null
  - monto: number
  - fecha_facturacion: string YYYY-MM-DD o null
  - fecha_pago: string YYYY-MM-DD o null
  - descripcion: string
  - uso_cfdi: string
  - forma_pago: string
* Si no hay filas válidas, devuelve [].

Devuelve solo el arreglo JSON como respuesta final.
PROMPT;

            $resultText = $client->createResponseWithFile(
                $fileId,
                $systemPrompt,
                $userPrompt
            );

            $this->responseText = $resultText;

            // 3) Intentar decodificar el JSON para mostrarlo en tabla
            $decoded = json_decode($resultText, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Enriquecer filas con referencia a Entrada existente y preparar datos para RequisicionFactura
                $folios = [];
                foreach ($decoded as $item) {
                    if (isset($item['model_folio']) && is_string($item['model_folio']) && $item['model_folio'] !== '') {
                        $folios[] = $item['model_folio'];
                    }
                }
                $folios = array_values(array_unique($folios));

                $folioToEntrada = [];
                if (!empty($folios)) {
                    $folioToEntrada = Entrada::whereIn('folio', $folios)
                        ->with('cliente:id,nombre')
                        ->get()
                        ->keyBy('folio');
                }

                // Preparar búsqueda por número de reporte normalizado (9 dígitos) cuando falte folio
                $normalizeReport = function ($value) {
                    if (!is_string($value)) return null;
                    $raw = strtoupper(trim($value));
                    // eliminar todo lo que no sea dígito
                    $digits = preg_replace('/[^0-9]/', '', $raw);
                    if (!$digits || strlen($digits) !== 9) {
                        return null;
                    }
                    return $digits;
                };

                $reportNumbers = [];
                foreach ($decoded as $item) {
                    $rep = $normalizeReport($item['numero_reporte'] ?? null);
                    if ($rep) { $reportNumbers[] = $rep; }
                }
                $reportNumbers = array_values(array_unique($reportNumbers));

                $reportToEntrada = [];
                foreach ($reportNumbers as $repNum) {
                    // Buscar candidatos por LIKE usando los primeros 5 dígitos para reducir resultados
                    $likeNeedle = substr($repNum, 0, 5);
                    $candidates = Entrada::whereNotNull('orden')
                        ->whereRaw('TRIM(orden) LIKE ?', ["%{$likeNeedle}%"])
                        ->with('cliente:id,nombre')
                        ->limit(25)
                        ->get();
                    $matched = null;
                    foreach ($candidates as $cand) {
                        $candNorm = preg_replace('/[^0-9]/', '', strtoupper((string) $cand->orden));
                        if ($candNorm === $repNum) {
                            $matched = $cand;
                            break;
                        }
                    }
                    if ($matched) {
                        $reportToEntrada[$repNum] = $matched;
                    }
                }

                // Normalizar aseguradora a valores válidos
                $validAseguradoras = ['QUALITAS', 'CENTAURO', 'PARTICULAR'];

                $prepared = [];
                foreach ($decoded as $item) {
                    $folio = (string) ($item['model_folio'] ?? '');
                    /** @var \App\Models\Entrada|null $entrada */
                    $entrada = $folio !== '' && isset($folioToEntrada[$folio]) ? $folioToEntrada[$folio] : null;
                    if (!$entrada) {
                        $repNorm = $normalizeReport($item['numero_reporte'] ?? null);
                        if ($repNorm && isset($reportToEntrada[$repNorm])) {
                            $entrada = $reportToEntrada[$repNorm];
                        }
                    }
                    $entradaId = $entrada?->id;

                    $aseg = strtoupper((string) ($item['aseguradora'] ?? ''));
                    if (!in_array($aseg, $validAseguradoras, true)) {
                        $aseg = 'PARTICULAR';
                    }

                    // cliente_id: si es PARTICULAR y hay entrada, usamos el cliente de la entrada
                    $clienteId = null;
                    $clienteNombre = null;
                    if ($aseg === 'PARTICULAR' && $entrada) {
                        $clienteId = $entrada->cliente_id;
                        $clienteNombre = $entrada->cliente?->nombre;
                    }

                    $repNorm = $normalizeReport($item['numero_reporte'] ?? null);

                    $numeroFactura = isset($item['numero_factura']) && is_string($item['numero_factura']) && $item['numero_factura'] !== ''
                        ? strtoupper(trim($item['numero_factura']))
                        : null;

                    $monto = isset($item['monto']) ? (float) $item['monto'] : null;

                    $descripcion = isset($item['descripcion']) && is_string($item['descripcion'])
                        ? trim($item['descripcion'])
                        : '';
                    if ($descripcion === '') {
                        $descParts = [];
                        if (isset($item['uso_semana'])) { $descParts[] = (string) $item['uso_semana']; }
                        if ($numeroFactura) { $descParts[] = $numeroFactura; }
                        if ($aseg) { $descParts[] = $aseg; }
                        if ($folio) { $descParts[] = $folio; }
                        $descripcion = trim(implode(' - ', array_filter($descParts))); // fallback corto
                    }

                    $usoCfdi = isset($item['uso_cfdi']) && is_string($item['uso_cfdi']) && $item['uso_cfdi'] !== ''
                        ? strtoupper($item['uso_cfdi'])
                        : 'G03';

                    $formaPago = isset($item['forma_pago']) && is_string($item['forma_pago']) && $item['forma_pago'] !== ''
                        ? $item['forma_pago']
                        : '99';

                    $prepared[] = [
                        // Campos para crear RequisicionFactura
                        'aseguradora' => $aseg,
                        'cliente_id' => $clienteId,
                        'model_type' => $entradaId ? Entrada::class : null,
                        'model_id' => $entradaId,
                        'uso_cfdi' => $usoCfdi,
                        'forma_pago' => $formaPago,
                        'descripcion' => $descripcion,
                        'monto' => $monto,
                        'numero_reporte' => $repNorm,
                        'numero_factura' => $numeroFactura,
                        'fecha_facturacion' => $item['fecha_facturacion'] ?? null,
                        'fecha_pago' => $item['fecha_pago'] ?? null,

                        // Metadatos para la UI
                        'model_folio' => $folio,
                        '_entrada_exists' => $entradaId !== null,
                        '_entrada_url' => $entradaId
                            ? url('/servicios/' . $entradaId)
                            : url('/servicios/busqueda?folio=' . urlencode($folio)),
                        '_cliente_nombre' => $clienteNombre,
                        '_numero_reporte' => $repNorm,
                    ];
                }

                $this->rows = $prepared;
            } else {
                // Si la respuesta no es JSON válido, lanzamos error para informar al usuario
                throw new \RuntimeException('La respuesta de OpenAI no es un JSON válido.');
            }
        } catch (\Throwable $e) {
            Log::error('Error al procesar ImportarPDF', [
                'message' => $e->getMessage(),
            ]);
            throw ValidationException::withMessages([
                'pdf' => 'Error al procesar el PDF: ' . $e->getMessage(),
            ]);
        } finally {
            $this->isLoading = false;
        }
    }

    public function resetForm(): void
    {
        $this->reset(['pdf', 'responseText', 'isLoading', 'rows']);
    }
} 