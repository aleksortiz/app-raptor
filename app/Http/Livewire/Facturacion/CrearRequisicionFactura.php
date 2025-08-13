<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\RequisicionFactura;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Models\Documento;
use App\Classes\FacturacionConstants;
use Illuminate\Support\Facades\Storage;

class CrearRequisicionFactura extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public RequisicionFactura $requisicion;

    public $searchKey;
    public $mdlNameCreate = 'mdlCreateRequisicion';

    public $selectedClienteNombre;
    public $selectedEntradaFolio;

    // Documento Constancia Fiscal
    public $constanciaFiscalFile; // Livewire UploadedFile

    protected $listeners = [
        'setCliente' => 'setCliente',
        'setEntrada' => 'setEntrada',
    ];

    protected function rules()
    {
        $usoCfdiKeys = implode(',', array_keys(FacturacionConstants::USO_CFDI));
        $formasPagoKeys = implode(',', array_keys(FacturacionConstants::FORMAS_PAGO));
        return [
            'requisicion.cliente_id' => 'required|integer|exists:clientes,id',
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
            $key = trim($this->searchKey);
            $query->where(function ($q) use ($key) {
                $q->orWhere('numero_factura', 'LIKE', "%{$key}%")
                  ->orWhere('descripcion', 'LIKE', "%{$key}%")
                  ->orWhere('uso_cfdi', 'LIKE', "%{$key}%")
                  ->orWhere('forma_pago', 'LIKE', "%{$key}%")
                  ->orWhere('monto', 'LIKE', "%{$key}%")
                  ->orWhereHas('cliente', function ($cq) use ($key) {
                      $cq->where('nombre', 'LIKE', "%{$key}%");
                  });
            });
        }

        return [
            'requisiciones' => $query->paginate(25, ['*'], 'requisicionesPage'),
            'usoCfdiOptions' => FacturacionConstants::USO_CFDI,
            'formasPagoOptions' => FacturacionConstants::FORMAS_PAGO,
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
            $this->requisicion->cliente_id = $entrada->cliente_id;
            $this->selectedClienteNombre = $entrada->cliente?->nombre;
            $this->selectedEntradaFolio = $entrada->folio;
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
}
