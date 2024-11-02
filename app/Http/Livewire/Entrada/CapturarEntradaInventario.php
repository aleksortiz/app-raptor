<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use App\Models\Fabricante;
use Livewire\Component;

class CapturarEntradaInventario extends Component
{
    public $firmar = false;

    public $cliente;
    public $telefono;
    public $marca;
    public $modelo;
    public $year;
    public $kilometros;
    public $color;
    public $placas;
    public $notas;
    public $gasolina;
    public $inventario;
    public $testigos;
    public $carroceria;
    public $mecanica;

    //INVENTARIO
    public $estereo;
    public $tapetes;
    public $parabrisas;
    public $gato;
    public $extra;
    public $herramientas;
    public $cables;

    //TESTIGOS
    public $abs;
    public $check_engine;
    public $antiderrapante;
    public $brake;
    public $bolsas;
    public $stability_track;

    //CARROCERIA
    public $puertas, $puertas_1, $puertas_2, $puertas_3, $puertas_4, $puertas_5;
    public $costados;
    public $piso_cajuela;
    public $tolva_escape;
    public $capacete;
    public $cofre;
    public $rep_granizo;
    public $pintura_general;
    public $fender;
    public $facia;
    public $carroceria_otro;

    //MECANICA
    public $afinacion_mayor;
    public $cambio_aceite;
    public $falla_mecanica;
    public $frenos;
    public $suspension;
    public $mecanica_otro;


    protected $rules = [
        'cliente' => 'required|string|max:255',
        'telefono' => 'required|string|max:255',
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'year' => 'nullable|numeric|digits:4',
        'kilometros' => 'nullable|numeric',
        'color' => 'required|string|max:255',
        'placas' => 'nullable|string|max:255',
        'notas' => 'nullable|string',
        'gasolina' => 'required|numeric|min:1|max:100',

        'estereo' => 'required|string',
        'tapetes' => 'required|string',
        'parabrisas' => 'required|string',
        'gato' => 'required|string',
        'extra' => 'required|string',
        'herramientas' => 'required|string',
        'cables' => 'required|string',
    ];

    protected $listeners = [
        'setGas',
    ];

    public function render(){
        return view('livewire.entrada.capturar-entrada-inventario.view', $this->getRenderData());
    }

    public function setGas($gasolina){
        $this->gasolina = $gasolina;
    }

    public function getRenderData(){
        return [
            'fabricantes' => Fabricante::OrderBy('nombre')->get(),
        ];
    }

    public function toggle(){

      $this->firmar = !$this->firmar;

      if($this->firmar){
        $this->emit('init-canvas');
      }
    }

    public function slider(){
      $this->emit('init-range-slider');
    }

    public function aceptar(){
        // $this->validate();
        // $this->entrada->save();
        // $this->emit('ok', 'Inventario guardado correctamente');
    }

}
