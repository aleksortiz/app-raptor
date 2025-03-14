<?php

namespace App\Http\Livewire\Vehiculo\Traits;

trait CreateVehiculoCuentaTrait
{
    public $vehiculoCuentaFecha;
    public $vehiculoCuentaVendedor;
    public $vehiculoCuentaDescripcion;
    public $vehiculoCuentaMonto;
    public $vehiculoCuentaNotas;

    public function createVehiculoCuenta(){
        $this->validate([
            'vehiculoCuentaFecha' => 'required|date',
            'vehiculoCuentaVendedor' => 'required|max:255',
            'vehiculoCuentaDescripcion' => 'required|max:255',
            'vehiculoCuentaMonto' => 'required|numeric',
            'vehiculoCuentaNotas' => 'nullable',
        ]);

        $this->vehiculo->vehiculos_cuenta()->create([
            'fecha' => $this->vehiculoCuentaFecha,
            'vendedor' => $this->vehiculoCuentaVendedor,
            'descripcion' => $this->vehiculoCuentaDescripcion,
            'monto' => $this->vehiculoCuentaMonto,
            'notas' => $this->vehiculoCuentaNotas,
        ]);

        $this->emit('ok', 'Se ha registrado vehículo');
        $this->emit('closeModal', '#mdlCreateVehiculoCuenta');

        $this->vehiculo->load('vehiculos_cuenta');

        $this->reset([
            'vehiculoCuentaFecha',
            'vehiculoCuentaVendedor',
            'vehiculoCuentaDescripcion',
            'vehiculoCuentaMonto',
            'vehiculoCuentaNotas',
        ]);
    }

    public function deleteVehiculoCuenta($id){
        $vehiculo_cuenta = $this->vehiculo->vehiculos_cuenta()->findOrFail($id);
        $vehiculo_cuenta->delete();
        $this->vehiculo->load('vehiculos_cuenta');
        $this->emit('ok', 'Vehículo eliminado');
    }
}