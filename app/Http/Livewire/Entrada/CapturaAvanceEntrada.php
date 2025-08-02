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
    public $mecanica;


    public function mount($id){
        $entrada = \App\Models\Entrada::find($id);
        $this->entradaId = $id;
        $this->avance = $entrada->avance;

        $this->carroceria = $this->avance?->carroceria;
        $this->preparado = $this->avance?->preparado;
        $this->pintura = $this->avance?->pintura;
        $this->armado = $this->avance?->armado;
        $this->mecanica = $this->avance?->mecanica;
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

        // Si se selecciona mecanica, limpiar todos los campos excepto terminado
        if($tipo == 'mecanica'){
            $this->avance = \App\Models\EntradaAvance::updateOrCreate(
                ['entrada_id' => $this->entradaId],
                [
                    'mecanica' => Carbon::now(),
                    'carroceria' => null,
                    'preparado' => null,
                    'pintura' => null,
                    'armado' => null,
                    'terminado' => $this->terminado,
                ]
            );
        }
        // Si se selecciona carroceria, limpiar mecanica y continuar flujo normal
        elseif($tipo == 'carroceria'){
            $this->avance = \App\Models\EntradaAvance::updateOrCreate(
                ['entrada_id' => $this->entradaId],
                [
                    'carroceria' => Carbon::now(),
                    'mecanica' => null,
                    'preparado' => $this->preparado,
                    'pintura' => $this->pintura,
                    'armado' => $this->armado,
                    'terminado' => $this->terminado,
                ]
            );
        }
        // Para otros campos, flujo normal
        else {
            $this->avance = \App\Models\EntradaAvance::updateOrCreate(
                ['entrada_id' => $this->entradaId],
                [
                    'carroceria' => $tipo == 'carroceria' ? Carbon::now() : $this->carroceria,
                    'preparado' => $tipo == 'preparado' ? Carbon::now() : $this->preparado,
                    'pintura' => $tipo == 'pintura' ? Carbon::now() : $this->pintura,
                    'armado' => $tipo == 'armado' ? Carbon::now() : $this->armado,
                    'mecanica' => $tipo == 'mecanica' ? Carbon::now() : $this->mecanica,
                    'terminado' => $tipo == 'terminado' ? Carbon::now() : $this->terminado,
                ]
            );
        }

        $this->carroceria = $this->avance?->carroceria;
        $this->preparado = $this->avance?->preparado;
        $this->pintura = $this->avance?->pintura;
        $this->armado = $this->avance?->armado;
        $this->terminado = $this->avance?->terminado;
        $this->mecanica = $this->avance?->mecanica;
    }
}
