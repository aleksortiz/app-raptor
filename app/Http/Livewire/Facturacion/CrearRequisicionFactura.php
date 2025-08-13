<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RequisicionFactura;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Classes\FacturacionConstants;

class CrearRequisicionFactura extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public RequisicionFactura $requisicion;

    public $searchKey;
    public $mdlNameCreate = 'mdlCreateRequisicion';

    public $selectedClienteNombre;
    public $selectedEntradaFolio;

    protected $listeners = [
        'setCliente' => 'setCliente',
        'setEntrada' => 'setEntrada',
    ];

    protected function rules()
    {
        $usoCfdiKeys = implode(',', array_keys(FacturacionConstants::USO_CFDI));
        return [
            'requisicion.cliente_id' => 'required|integer|exists:clientes,id',
            'requisicion.model_id' => 'nullable|integer',
            'requisicion.model_type' => 'nullable|string',
            'requisicion.uso_cfdi' => "nullable|in:{$usoCfdiKeys}",
            'requisicion.metodo_pago' => 'nullable|string|max:50',
            'requisicion.descripcion' => 'nullable|string|max:1000',
            'requisicion.monto' => 'nullable|numeric|min:0',
            'requisicion.numero_factura' => 'nullable|string|max:100',
            'requisicion.fecha_facturacion' => 'nullable|date',
            'requisicion.fecha_pago' => 'nullable|date',
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
                  ->orWhere('metodo_pago', 'LIKE', "%{$key}%")
                  ->orWhere('monto', 'LIKE', "%{$key}%")
                  ->orWhereHas('cliente', function ($cq) use ($key) {
                      $cq->where('nombre', 'LIKE', "%{$key}%");
                  });
            });
        }

        return [
            'requisiciones' => $query->paginate(25, ['*'], 'requisicionesPage'),
            'usoCfdiOptions' => FacturacionConstants::USO_CFDI,
        ];
    }

    public function openCreate()
    {
        $this->requisicion = new RequisicionFactura();
        $this->selectedClienteNombre = null;
        $this->selectedEntradaFolio = null;
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
        $this->requisicion->save();
        $this->emit('ok', 'Requisición registrada correctamente');
        $this->emit('closeModal', "#{$this->mdlNameCreate}");
        $this->requisicion = new RequisicionFactura();
        $this->selectedClienteNombre = null;
        $this->selectedEntradaFolio = null;
        $this->resetPage('requisicionesPage');
    }
}
