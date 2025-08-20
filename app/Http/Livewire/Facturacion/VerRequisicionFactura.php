<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;
use App\Models\RequisicionFactura;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Models\Documento;
use App\Classes\FacturacionConstants;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class VerRequisicionFactura extends Component
{
    public $requisicion;
    public $selectedRequisicionId;
    public $numeroFactura;
    public $fechaPago;
    public $constanciaUrl;
    public $ordenAdmisionUrl;
    public $ineUrl;
    public $entrada;
    
    protected $listeners = [
        'saveFacturaPago'
    ];
    
    public function mount($id = null)
    {
        if ($id) {
            $this->loadRequisicion($id);
        }
    }
    
    public function render()
    {
        return view('livewire.facturacion.ver-requisicion-factura.view', [
            'usoCfdiOptions' => FacturacionConstants::USO_CFDI,
            'formasPagoOptions' => FacturacionConstants::FORMAS_PAGO,
        ]);
    }
    
    public function loadRequisicion($id)
    {
        $req = RequisicionFactura::with(['cliente'])->findOrFail($id);
        $this->requisicion = $req;
        $this->selectedRequisicionId = $req->id;
        $this->numeroFactura = $req->numero_factura;
        $this->fechaPago = $req->fecha_pago;
        
        // Obtener URL de constancia fiscal
        $doc = $req->cliente?->documentos()->where('tipo', 'CONSTANCIA FISCAL')->first();
        $this->constanciaUrl = $this->buildS3Url($doc?->url);
        
        // Obtener URL de orden de admisión e INE si hay entrada relacionada
        $this->ordenAdmisionUrl = null;
        $this->ineUrl = null;
        $this->entrada = null;
        if ($req->model_type === Entrada::class && $req->model_id) {
            $entrada = Entrada::find($req->model_id);
            if ($entrada) {
                $this->entrada = $entrada;
                $docOrdenAdmision = $entrada->documentos()->where('tipo', 'ORDEN_ADMISION')->first();
                $this->ordenAdmisionUrl = $this->buildS3Url($docOrdenAdmision?->url);
                
                // Obtener URL del INE de la entrada
                $docIne = $entrada->documentos()->where('tipo', 'INE')->first();
                $this->ineUrl = $this->buildS3Url($docIne?->url);
            }
        }
    }
    
    public function saveFacturaPago()
    {
        $req = RequisicionFactura::findOrFail($this->selectedRequisicionId);
        
        if (empty($req->numero_factura)) {
            $this->validate([
                'numeroFactura' => 'required|string|max:100',
                'fechaPago' => 'nullable|date',
            ]);
            $req->numero_factura = $this->numeroFactura;
            if ($this->fechaPago) {
                $req->fecha_pago = $this->fechaPago;
            }
        } elseif (empty($req->fecha_pago)) {
            $this->validate([
                'fechaPago' => 'required|date',
            ]);
            $req->fecha_pago = $this->fechaPago;
        }
        
        $req->save();
        $this->requisicion = $req->fresh('cliente');
        $this->emit('ok', 'Datos actualizados');
    }
    
    public function goBack()
    {
        return redirect()->route('facturacion.requisiciones');
    }
    
    /**
     * Descarga en un ZIP todos los documentos relacionados:
     * - Documentos y fotos de la Entrada relacionada (si existe)
     * - Documentos del Cliente relacionado (si existe)
     */
    public function downloadTodosDocumentos()
    {
        $req = RequisicionFactura::with(['cliente' => function($q){
            $q->with('documentos');
        }])->findOrFail($this->selectedRequisicionId);

        $zipFileName = 'requisicion_' . $req->id . '_documentos.zip';
        $tempZipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'No se pudo crear el archivo ZIP.');
        }

        $addedFiles = 0;

        // Entrada (documentos y fotos)
        if ($req->model_type === Entrada::class && $req->model_id) {
            $entrada = Entrada::with(['documentos', 'fotos'])->find($req->model_id);
            if ($entrada) {
                $entradaFolder = 'entrada_' . ($entrada->folio ?: $entrada->id);
                // Documentos de la entrada
                foreach ($entrada->documentos as $doc) {
                    $addedFiles += $this->addS3FileToZip($zip, $doc->url, $entradaFolder . '/documentos/' . $this->buildDocumentoFileName($doc->name ?? null, $doc->tipo ?? null, $doc->url)) ? 1 : 0;
                }
                // Fotos de la entrada
                foreach ($entrada->fotos as $foto) {
                    $addedFiles += $this->addS3FileToZip($zip, $foto->url, $entradaFolder . '/fotos/' . basename($this->toS3Path($foto->url) ?? 'foto.jpg')) ? 1 : 0;
                }
            }
        }

        // Documentos del cliente
        if ($req->cliente) {
            $clienteFolder = 'cliente_' . $req->cliente->id;
            foreach ($req->cliente->documentos as $doc) {
                $addedFiles += $this->addS3FileToZip($zip, $doc->url, $clienteFolder . '/documentos/' . $this->buildDocumentoFileName($doc->name ?? null, $doc->tipo ?? null, $doc->url)) ? 1 : 0;
            }
        }

        $zip->close();

        if ($addedFiles <= 0) {
            @unlink($tempZipPath);
            $this->emit('error', 'No hay documentos o fotos para descargar.');
            return null;
        }

        return response()->download($tempZipPath)->deleteFileAfterSend(true);
    }
    
    private function buildS3Url(?string $path): ?string
    {
        if (!$path) return null;
        $bucket = env('AWS_BUCKET_URL');
        if (!$bucket) return $path;
        $bucket = rtrim($bucket, '/');
        $path = ltrim($path, '/');
        if (str_contains($path, $bucket)) {
            return $path;
        }
        return "$bucket/$path";
    }

    /**
     * Convierte una URL completa del bucket o una ruta relativa en ruta válida para Storage S3
     */
    private function toS3Path(?string $urlOrPath): ?string
    {
        if (!$urlOrPath) return null;
        $bucket = env('AWS_BUCKET_URL');
        if ($bucket && str_contains($urlOrPath, $bucket)) {
            $path = str_replace($bucket, '', $urlOrPath);
            return ltrim($path, '/');
        }
        return ltrim($urlOrPath, '/');
    }

    /**
     * Agrega un archivo alojado en S3 al ZIP, si existe
     */
    private function addS3FileToZip(ZipArchive $zip, ?string $urlOrPath, string $zipInternalPath): bool
    {
        $s3Path = $this->toS3Path($urlOrPath);
        if (!$s3Path) return false;
        try {
            if (Storage::disk('s3')->exists($s3Path)) {
                $contents = Storage::disk('s3')->get($s3Path);
                $zip->addFromString($zipInternalPath, $contents);
                return true;
            }
        } catch (\Throwable $th) {
            // Ignorar archivos inaccesibles en el ZIP
        }
        return false;
    }

    /**
     * Construye un nombre de archivo amigable para documentos
     */
    private function buildDocumentoFileName(?string $originalName, ?string $tipo, string $fallbackUrl): string
    {
        $base = $originalName ?: ($tipo ?: basename(parse_url($fallbackUrl, PHP_URL_PATH)) ?: 'documento');
        $base = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $base);
        if (!pathinfo($base, PATHINFO_EXTENSION)) {
            $ext = pathinfo(parse_url($fallbackUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'pdf';
            $base .= '.' . $ext;
        }
        return $base;
    }
}
