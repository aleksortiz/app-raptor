<?php

namespace App\Http\Livewire\Vehiculo\Traits;

trait CreateGastoTrait
{
    public $gastoConcepto;
    public $gastoMonto;
    public $gastoFecha;

    public function createGasto(){
        $this->validate([
            'gastoConcepto' => 'required|max:255',
            'gastoMonto' => 'required|numeric|min:0',
            'gastoFecha' => 'required|date',
        ]);

        $this->vehiculo->gastos()->create([
            'descripcion' => $this->gastoConcepto,
            'monto' => $this->gastoMonto,
            'fecha' => $this->gastoFecha,
        ]);

        $this->emit('ok', 'Gasto registrado');
        $this->emit('closeModal', '#mdlCreateGasto');
        $this->vehiculo->load('gastos');
        $this->reset(['gastoConcepto', 'gastoMonto', 'gastoFecha']);
    }

    public function deleteGasto($id){
        $gasto = $this->vehiculo->gastos()->findOrFail($id);
        $gasto->delete();
        $this->vehiculo->load('gastos');
        $this->emit('ok', 'Gasto eliminado');
    }
}