<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\RequisicionFactura;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Classes\FacturacionConstants;
use Illuminate\Support\Facades\Storage;

class CrearRequisicionFactura extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public RequisicionFactura $requisicion;

    public $searchKey;
    public $mdlNameCreate = 'mdlCreateRequisicion';
    
    // Filtros por semana
    public $start;
    public $end;
    public $year;
    public $maxYear;

    public $selectedClienteNombre;
    public $selectedEntradaFolio;

    // Documento Constancia Fiscal
    public $constanciaFiscalFile; // Livewire UploadedFile

    // Modales de actualización
    public $mdlNameFactura = 'mdlCapturaFactura';
    public $mdlNamePago = 'mdlCapturaPago';
    public $selectedRequisicionId;
    public $numeroFactura;
    public $fechaPago;

    // Modal detalles
    public $mdlNameDetalles = 'mdlDetallesRequisicion';
    public $detalleReq;
    public $constanciaUrl;

    // Opciones Aseguradora (Facturar A)
    public array $aseguradoraOptions = [
        'QUALITAS' => 'QUALITAS',
        'CENTAURO' => 'CENTAURO',
        'AUTOS JUVENTUD CHIHUAHUA' => 'AUTOS JUVENTUD CHIHUAHUA',
        'TU MEJOR AGENCIA' => 'TU MEJOR AGENCIA',
        'PARTICULAR' => 'PARTICULAR',
    ];

    protected $listeners = [
        'setCliente' => 'setCliente',
        'setEntrada' => 'setEntrada',
        'deleteRequisicion',
    ];
    
    protected $queryString = ['year', 'start', 'end', 'searchKey'];

    protected function rules()
    {
        $usoCfdiKeys = implode(',', array_keys(FacturacionConstants::USO_CFDI));
        $formasPagoKeys = implode(',', array_keys(FacturacionConstants::FORMAS_PAGO));
        $aseguradoraKeys = implode(',', array_keys($this->aseguradoraOptions));
        $clienteIdRule = ($this->requisicion->aseguradora === 'PARTICULAR') ? 'required' : 'nullable';
        return [
            'requisicion.aseguradora' => "required|in:{$aseguradoraKeys}",
            'requisicion.cliente_id' => "{$clienteIdRule}|integer|exists:clientes,id",
            'requisicion.model_id' => 'nullable|integer',
            'requisicion.model_type' => 'nullable|string',
            'requisicion.uso_cfdi' => "required|in:{$usoCfdiKeys}",
            'requisicion.forma_pago' => "required|in:{$formasPagoKeys}",
            'requisicion.descripcion' => 'required|string|max:1000',
            'requisicion.monto' => 'required|numeric|min:0',
            'constanciaFiscalFile' => 'nullable|file|max:10240',
        ];
    }

    public function mount()
    {
        $this->requisicion = new RequisicionFactura();
        
        // Inicializar filtros de semana
        $this->start = $this->start ? $this->start : \Carbon\Carbon::today()->weekOfYear;
        $this->end = $this->end ? $this->end : \Carbon\Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : \Carbon\Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function updatingSearchKey()
    {
        $this->resetPage('requisicionesPage');
    }

    public function render()
    {
        return view('livewire.facturacion.crear-requisicion-factura.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $query = RequisicionFactura::query()->orderBy('id', 'desc');
        
        if ($this->searchKey) {
            // Apply search filters
            $key = trim($this->searchKey);
            $query->where(function ($q) use ($key) {
                $q->orWhere('numero_factura', 'LIKE', "%{$key}%")
                  ->orWhere('descripcion', 'LIKE', "%{$key}%")
                  ->orWhere('aseguradora', 'LIKE', "%{$key}%")
                  ->orWhere('uso_cfdi', 'LIKE', "%{$key}%")
                  ->orWhere('forma_pago', 'LIKE', "%{$key}%")
                  ->orWhere('monto', 'LIKE', "%{$key}%")
                  ->orWhereHas('cliente', function ($cq) use ($key) {
                      $cq->where('nombre', 'LIKE', "%{$key}%");
                  });
            });
        } else {
            // Apply date range filters only if not searching
            $dates = Entrada::getDateRange($this->year, $this->start, $this->end);
            $query->whereBetween('created_at', $dates);
        }

        return [
            'requisiciones' => $query->paginate(25, ['*'], 'requisicionesPage'),
            'usoCfdiOptions' => FacturacionConstants::USO_CFDI,
            'formasPagoOptions' => FacturacionConstants::FORMAS_PAGO,
            'aseguradoraOptions' => $this->aseguradoraOptions,
            'clienteNecesitaConstanciaFiscal' => $this->clienteNecesitaConstanciaFiscal(),
        ];
    }

    public function openCreate()
    {
        $this->requisicion = new RequisicionFactura();
        $this->selectedClienteNombre = null;
        $this->selectedEntradaFolio = null;
        $this->constanciaFiscalFile = null;
        $this->emit('showModal', "#{$this->mdlNameCreate}");
    }

    public function setCliente($clienteId)
    {
        // Solo permitir seleccionar cliente si es PARTICULAR
        if ($this->requisicion->aseguradora !== 'PARTICULAR') {
            return;
        }
        $cliente = Cliente::find($clienteId);
        if ($cliente) {
            // Al seleccionar cliente manualmente, limpiamos entrada para evitar conflictos
            $this->clearEntrada(false);
            $this->requisicion->cliente_id = $cliente->id;
            $this->selectedClienteNombre = $cliente->nombre;
        }
    }

    public function setEntrada($entradaId)
    {
        // Si ya hay cliente seleccionado, no permitir seleccionar entrada
        if (!empty($this->requisicion->cliente_id)) {
            return;
        }
        $entrada = Entrada::with('cliente')->find($entradaId);
        if ($entrada) {
            $this->requisicion->model_type = Entrada::class;
            $this->requisicion->model_id = $entrada->id;
            $this->selectedEntradaFolio = $entrada->folio;

            // Asignar cliente desde entrada solo si es PARTICULAR
            if ($this->requisicion->aseguradora === 'PARTICULAR') {
                $this->requisicion->cliente_id = $entrada->cliente_id;
                $this->selectedClienteNombre = $entrada->cliente?->nombre;
            } else {
                $this->requisicion->cliente_id = null;
                $this->selectedClienteNombre = null;
            }
        }
    }

    public function clearCliente($clearEntradaAlso = true)
    {
        $this->requisicion->cliente_id = null;
        $this->selectedClienteNombre = null;
        if ($clearEntradaAlso) {
            $this->clearEntrada(false);
        }
    }

    public function clearEntrada($keepClient = true)
    {
        $this->requisicion->model_type = null;
        $this->requisicion->model_id = null;
        $this->selectedEntradaFolio = null;
        if (!$keepClient) {
            $this->requisicion->cliente_id = null;
            $this->selectedClienteNombre = null;
        }
    }

    public function save()
    {
        $this->validate();

        // Antes de guardar, asegurar CONSTANCIA FISCAL
        if ($this->clienteNecesitaConstanciaFiscal()) {
            // si no hay archivo cargado, avisar
            if (!$this->constanciaFiscalFile) {
                $this->emit('error', 'El cliente no tiene CONSTANCIA FISCAL. Cárguela para continuar.');
                return;
            }

            $this->uploadConstanciaFiscal();
        }

        $this->requisicion->save();
        $this->emit('ok', 'Requisición registrada correctamente');
        $this->emit('closeModal', "#{$this->mdlNameCreate}");
        $this->requisicion = new RequisicionFactura();
        $this->selectedClienteNombre = null;
        $this->selectedEntradaFolio = null;
        $this->constanciaFiscalFile = null;
        $this->resetPage('requisicionesPage');
    }

    public function clienteNecesitaConstanciaFiscal(): bool
    {
        if (empty($this->requisicion->cliente_id)) {
            return false;
        }
        $cliente = Cliente::with('documentos')->find($this->requisicion->cliente_id);
        if (!$cliente) return false;
        return !$cliente->documentos()->where('tipo', 'CONSTANCIA FISCAL')->exists();
    }

    public function uploadConstanciaFiscal()
    {
        $this->validateOnly('constanciaFiscalFile');

        $cliente = Cliente::find($this->requisicion->cliente_id);
        if (!$cliente) return;

        $ext = $this->constanciaFiscalFile->getClientOriginalExtension();
        $filename = 'cliente_' . $cliente->id . '_CONSTANCIA_FISCAL_' . time() . '.' . $ext;
        $path = $this->constanciaFiscalFile->storeAs('documentos/clientes/' . $cliente->id, $filename, 's3');

        // Eliminar existente si hubiera
        $existing = $cliente->documentos()->where('tipo', 'CONSTANCIA FISCAL')->first();
        if ($existing) {
            if (Storage::disk('s3')->exists($existing->url)) {
                Storage::disk('s3')->delete($existing->url);
            }
            $existing->delete();
        }

        $cliente->documentos()->create([
            'tipo' => 'CONSTANCIA FISCAL',
            'url' => $path,
            'name' => $filename,
            'user_id' => auth()->id(),
        ]);

        $this->constanciaFiscalFile = null;
    }

    // ==== Captura Factura / Pago ====
    public function openCapturaFactura($id)
    {
        $req = RequisicionFactura::findOrFail($id);
        $this->selectedRequisicionId = $req->id;
        $this->numeroFactura = $req->numero_factura;
        $this->fechaPago = $req->fecha_pago;
        $this->emit('showModal', "#{$this->mdlNameFactura}");
    }

    public function saveCapturaFactura()
    {
        $this->validate([
            'numeroFactura' => 'required|string|max:100',
            'fechaPago' => 'nullable|date',
        ]);
        $req = RequisicionFactura::findOrFail($this->selectedRequisicionId);
        $req->numero_factura = $this->numeroFactura;
        if ($this->fechaPago) {
            $req->fecha_pago = $this->fechaPago;
        }
        $req->save();
        $this->emit('ok', 'Datos de factura actualizados');
        $this->emit('closeModal', "#{$this->mdlNameFactura}");
        $this->reset(['selectedRequisicionId', 'numeroFactura', 'fechaPago']);
    }

    public function openCapturaPago($id)
    {
        $req = RequisicionFactura::findOrFail($id);
        $this->selectedRequisicionId = $req->id;
        $this->fechaPago = $req->fecha_pago;
        $this->emit('showModal', "#{$this->mdlNamePago}");
    }

    public function saveCapturaPago()
    {
        $this->validate([
            'fechaPago' => 'required|date',
        ]);
        $req = RequisicionFactura::findOrFail($this->selectedRequisicionId);
        $req->fecha_pago = $this->fechaPago;
        $req->save();
        $this->emit('ok', 'Fecha de pago registrada');
        $this->emit('closeModal', "#{$this->mdlNamePago}");
        $this->reset(['selectedRequisicionId', 'fechaPago']);
    }

    public function deleteRequisicion($id)
    {
        $req = RequisicionFactura::findOrFail($id);
        if (!empty($req->numero_factura)) {
            $this->emit('error', 'No se puede eliminar: la requisición ya tiene número de factura.');
            return;
        }
        $req->delete();
        $this->emit('ok', 'Requisición eliminada');
        $this->resetPage('requisicionesPage');
    }

    // ==== Detalles ====
    public function openDetalles($id)
    {
        $req = RequisicionFactura::with('cliente')->findOrFail($id);
        $this->detalleReq = $req;
        $this->selectedRequisicionId = $req->id;
        $this->numeroFactura = $req->numero_factura;
        $this->fechaPago = $req->fecha_pago;
        $doc = $req->cliente?->documentos()->where('tipo', 'CONSTANCIA FISCAL')->first();
        $this->constanciaUrl = $this->buildS3Url($doc?->url);
        $this->emit('showModal', "#{$this->mdlNameDetalles}");
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
        $this->detalleReq = $req->fresh('cliente');
        $this->emit('ok', 'Datos actualizados');
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

    public function updatedRequisicionAseguradora($value)
    {
        if ($value !== 'PARTICULAR') {
            $this->clearCliente(false);
        } else {
            // Si cambia a PARTICULAR y hay una entrada seleccionada, obtener el cliente de esa entrada
            if ($this->requisicion->model_type === Entrada::class && $this->requisicion->model_id) {
                $entrada = Entrada::with('cliente')->find($this->requisicion->model_id);
                if ($entrada && $entrada->cliente_id) {
                    $this->requisicion->cliente_id = $entrada->cliente_id;
                    $this->selectedClienteNombre = $entrada->cliente?->nombre;
                }
            }
        }
    }
}
