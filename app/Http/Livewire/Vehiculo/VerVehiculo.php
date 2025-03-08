<?php

namespace App\Http\Livewire\Vehiculo;

use App\Http\Livewire\Vehiculo\Traits\CreateContratoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateGastoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateParteTrait;
use App\Models\Vehiculo;
use Livewire\Component;

class VerVehiculo extends Component
{
    use CreateGastoTrait, CreateParteTrait, CreateContratoTrait;

    public $tab;

    public $vehiculo;
    public $lastUrl;

    public $descripcionVenta;
    public $emailAddress;

    // public $gastos;
    
    protected $rules = [
        'vehiculo.gastos.*.descripcion' => 'required|string|max:255',
        'vehiculo.gastos.*.estimacion' => 'required|numeric',
        'vehiculo.gastos.*.monto' => 'required|numeric',
        'vehiculo.moneda' => 'required|string|max:3',
        'vehiculo.cotizacion_usd' => 'required|numeric',
    ];

    protected $listeners = [
        'deleteGasto',
        'deleteParte',
    ];

    protected $queryString = [
        'tab' => ['except' => ''],
    ];

    public function mount($id){
        $this->contratoFecha = now()->format('Y-m-d');
        $this->lastUrl = url()->previous();
        $this->vehiculo = Vehiculo::findOrFail($id);
        $this->descripcionVenta = $this->vehiculo->descripcion_venta;
    }

    public function render()
    {
        return view('livewire.vehiculo.ver-vehiculo.view');
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }

    public function saveGastos(){
        $this->validate();

        foreach ($this->vehiculo->gastos as $gasto) {
            $gasto->save();
        }
        
        $this->emit('ok', 'Se han guardado gastos');
    }

    public function addGasto(){
        $this->vehiculo->gastos()->create([
            'fecha' => now(),
            'estimacion' => 0,
            'monto' => 0,
            'descripcion' => '',
        ]);

        // $this->gastos = $this->vehiculo->gastos;
        $this->vehiculo->load('gastos');
    }

    public function saveDescripcionVenta(){
        $this->vehiculo->descripcion_venta = $this->descripcionVenta;
        $this->vehiculo->save();
        $this->emit('ok', 'Se ha guardado la descripción de venta');
    }

    public function mdlSendMail(){
        $this->emit('showModal', '#mdlSendMail');
    }

    public function sendMail(){
        $this->validate([
            'emailAddress' => 'required',
        ]);

        $this->vehiculo->sendMail($this->emailAddress);
        $this->emit('ok', 'Correo enviado');
        $this->emit('closeModal', '#mdlSendMail');
        $this->reset('emailAddress');
    }

    //TODO: notas agarre carros a cuenta
    //TODO: clientes catalogo
    //TODO: agregaste carros a cuenta? y senalar en contrato
    //TODO: ver status de vehiculo

}
