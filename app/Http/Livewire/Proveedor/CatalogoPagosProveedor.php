<?php

namespace App\Http\Livewire\Proveedor;

use App\Models\Entrada;
use App\Models\PagoProveedor;
use App\Models\Proveedor;
use Carbon\Carbon;
use Livewire\Component;

class CatalogoPagosProveedor extends Component
{
    public $selectedProvider;
    public $pagoMonto;

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    protected $rules = [
        'selectedProvider.nombre' => 'string',
        'pagoMonto' => 'required|numeric|min:0.01',
    ];

    protected $query = [
        'weekStart', 'year'
    ];

    public function mount(){
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.proveedor.catalogo-pagos-proveedor.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekStart);
        return [
            'data' => PagoProveedor::whereBetween('created_at', $dates)->get(),
            'proveedores' => Proveedor::all(),
        ];
    }

    public function mdlPagar($id){
        $this->selectedProvider = Proveedor::findOrFail($id);
        $this->emit('showModal', '#mdl');
    }

    public function registrarPago(){
        $this->validate([
            'pagoMonto' => 'required|numeric|min:0.01'
        ]);
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekStart);
        PagoProveedor::create([
            'fecha' => $dates[0],
            'user_id' => auth()->id(),
            'proveedor_id' => $this->selectedProvider->id,
            'monto' => $this->pagoMonto,
        ]);
        $this->pagoMonto = null;
        $this->emit('closeModal', '#mdl');
        $this->emit('ok', 'Pago registrado correctamente');
    }
}
