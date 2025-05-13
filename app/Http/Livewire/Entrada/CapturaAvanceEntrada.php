<?php

namespace App\Http\Livewire\Entrada;

use Carbon\Carbon;
use Livewire\Component;

class CapturaAvanceEntrada extends Component
{
    public $avance;
    public $entradaId;

    public $carroceria;
    public $preparado;
    public $pintura;
    public $armado;
    public $terminado;

    public function mount($id){
        $entrada = \App\Models\Entrada::find($id);
        $this->entradaId = $id;
        $this->avance = $entrada->avance;

        $this->carroceria = $this->avance?->carroceria;
        $this->preparado = $this->avance?->preparado;
        $this->pintura = $this->avance?->pintura;
        $this->armado = $this->avance?->armado;
        $this->terminado = $this->avance?->terminado;
    }

    public function render()
    {
        return view('livewire.entrada.captura-avance-entrada');
    }

    public function check($tipo){

        if($tipo == 'terminado'){
            $this->redirect('/servicios/'.$this->entradaId.'/final-checklist');
            return;
        }


        $this->avance = \App\Models\EntradaAvance::updateOrCreate(
            ['entrada_id' => $this->entradaId],
            [
                'carroceria' => $tipo == 'carroceria' ? Carbon::now() : $this->carroceria,
                'preparado' => $tipo == 'preparado' ? Carbon::now() : $this->preparado,
                'pintura' => $tipo == 'pintura' ? Carbon::now() : $this->pintura,
                'armado' => $tipo == 'armado' ? Carbon::now() : $this->armado,
                'terminado' => $tipo == 'terminado' ? Carbon::now() : $this->terminado,
            ]
        );

        $this->carroceria = $this->avance?->carroceria;
        $this->preparado = $this->avance?->preparado;
        $this->pintura = $this->avance?->pintura;
        $this->armado = $this->avance?->armado;
        $this->terminado = $this->avance?->terminado;
    }
}
