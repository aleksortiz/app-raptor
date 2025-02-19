<?php

namespace App\Http\Livewire\Vehiculo\Traits;

trait CreateParteTrait
{
    public $parteDescripcion;
    public $parteNumero;
    public $parteCantidad;
    public $parteCosto;
    public $parteFecha;

    public function createParte(){
        $this->validate([
            'parteDescripcion' => 'required|max:255',
            'parteNumero' => 'required',
            'parteCantidad' => 'required|numeric',
            'parteCosto' => 'required|numeric',
            'parteFecha' => 'required|date',
        ]);

        $this->vehiculo->partes()->create([
            'descripcion' => $this->parteDescripcion,
            'numero_parte' => $this->parteNumero,
            'cantidad' => $this->parteCantidad,
            'costo' => $this->parteCosto,
            'fecha' => $this->parteFecha,
        ]);

        $this->emit('ok', 'Parte registrada');
        $this->emit('closeModal', '#mdlCreateParte');

        $this->vehiculo->load('partes');

        $this->reset([
            'parteDescripcion',
            'parteNumero',
            'parteCantidad',
            'parteCosto',
            'parteFecha',
        ]);
    }

    public function deleteParte($id){
        $parte = $this->vehiculo->partes()->findOrFail($id);
        $parte->delete();
        $this->vehiculo->load('partes');
        $this->emit('ok', 'parte eliminado');
    }
}