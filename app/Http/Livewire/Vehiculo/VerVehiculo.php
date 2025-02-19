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
    }

    public function render()
    {
        return view('livewire.vehiculo.ver-vehiculo.view');
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }


}
