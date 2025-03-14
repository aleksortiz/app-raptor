<?php

namespace App\Http\Livewire\Vehiculo;

use App\Http\Livewire\Vehiculo\Traits\CreateContratoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateGastoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateParteTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateVehiculoCuentaTrait;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class VerVehiculo extends Component
{
    use CreateGastoTrait, CreateParteTrait, CreateContratoTrait, CreateVehiculoCuentaTrait;

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

        'vehiculo.marca' => 'required',
        'vehiculo.modelo' => 'required',
        'vehiculo.year' => 'required',
        'vehiculo.color' => 'required',
        'vehiculo.serie' => 'nullable',
        'vehiculo.placa' => 'nullable',
        'vehiculo.factura' => 'nullable',
        'vehiculo.pedimento' => 'nullable',
        'vehiculo.precio_venta' => 'required',
        'vehiculo.numero_lote' => 'nullable',
        'vehiculo.estado' => 'nullable',

    ];

    protected $listeners = [
        'deleteGasto',
        'deleteParte',
        'deleteVehiculoCuenta',
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
        return view('livewire.vehiculo.ver-vehiculo.view', $this->getRenderData());
    }

    public function getRenderData(){
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);
        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
        ];
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

    public function saveData(){
        $this->validate([
            'vehiculo.marca' => 'required',
            'vehiculo.modelo' => 'required',
            'vehiculo.year' => 'required',
            'vehiculo.color' => 'required',
            'vehiculo.serie' => 'nullable',
            'vehiculo.placa' => 'nullable',
            'vehiculo.factura' => 'nullable',
            'vehiculo.pedimento' => 'nullable',
            'vehiculo.precio_venta' => 'required',
            'vehiculo.numero_lote' => 'nullable',
            'vehiculo.estado' => 'nullable',
        ]);

        $this->vehiculo->save();
        $this->emit('closeModal', '#mdlEdit');
        $this->emit('ok', 'Se han guardado los datos');
    }

    //**TODO: notas agarre carros a cuenta
    //TODO: clientes catalogo
    //TODO: agregaste carros a cuenta y senalar en contrato
    //**TODO: ver status de vehiculo
    //**TODO: Numero de Lote
    //TODO: Editar y Fecha de venta

}
