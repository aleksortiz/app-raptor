<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Valuacion;
use Livewire\Component;

class CalendarioValuaciones extends Component
{
    public $eventos;

    public function render()
    {
        return view('livewire.valuacion.calendario-valuaciones.view', $this->getRenderData());
    }

    public function getRenderData(){
      $this->eventos = Valuacion::all()->map(function ($cita) {
          return [
              'id' => $cita->id,
              'title' => $cita->vehiculo,
              'start' => $cita->fecha_cita,
              'color' => $cita->valuacion_efectuada ? 'green' : 'red',
          ];
      });

      return [];
    }
}
