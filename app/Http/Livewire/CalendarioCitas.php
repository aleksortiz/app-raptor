<?php

namespace App\Http\Livewire;

use App\Models\RegistroQr;
use Livewire\Component;

class CalendarioCitas extends Component
{
    public $citas;

    public function render()
    {
        return view('livewire.calendario-citas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $this->citas = RegistroQr::where('active', true)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->vehiculo,
                'start' => $item->fecha_cita,
                'color' => $item->tipo == 'VALUACION' ? 'blue' : 'green',
            ];
        });
  
        return [];
      }
}
