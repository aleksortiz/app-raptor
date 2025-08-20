<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;
use App\Models\RequisicionFactura;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Models\Documento;
use App\Classes\FacturacionConstants;
use Illuminate\Support\Facades\Storage;

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
}
