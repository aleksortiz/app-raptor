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

    // public $gastos;
    
    protected $rules = [
        'vehiculo.gastos.*.descripcion' => 'required|string|max:255',
        'vehiculo.gastos.*.estimacion' => 'required|numeric',
        'vehiculo.gastos.*.monto' => 'required|numeric',
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

        // $this->gastos = $this->vehiculo->gastos;
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


}
