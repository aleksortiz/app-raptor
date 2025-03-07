<?php

namespace App\Http\Livewire\Vehiculo;

use App\Models\Vehiculo;
use Livewire\Component;

class VerVehiculoPublic extends Component
{
    public $vehiculo;

    public function mount($id)
    {
        $this->vehiculo = Vehiculo::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.vehiculo.ver-vehiculo-public.view');
    }
}
