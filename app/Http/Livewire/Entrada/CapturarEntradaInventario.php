<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use App\Models\EntradaInventario;
use App\Models\Fabricante;
use Illuminate\Support\Facades\Auth;
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
    public $costados, $costados_izquierdo, $costados_derecho;
    public $piso_cajuela;
    public $tolva_escape;
    public $capacete;
    public $cofre;
    public $rep_granizo;
    public $pintura_general;
    public $fender, $fender_izquierdo, $fender_derecho;
    public $facia, $facia_delantera, $facia_trasera;
    public $carroceria_otro, $carroceria_otro_text;

    //MECANICA
    public $afinacion_mayor;
    public $cambio_aceite;
    public $falla_mecanica, $falla_mecanica_text;
    public $frenos;
    public $suspension, $suspension_text;
    public $mecanica_otro, $mecanica_otro_text;


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

        'estereo' => 'required|string',
        'tapetes' => 'required|string',
        'parabrisas' => 'required|string',
        'gato' => 'required|string',
        'extra' => 'required|string',
        'herramientas' => 'required|string',
        'cables' => 'required|string',
        'carroceria_otro_text' => 'required_if:carroceria_otro,true',
        'falla_mecanica_text' => 'required_if:falla_mecanica,true',
        'suspension_text' => 'required_if:suspension,true',
        'mecanica_otro_text' => 'required_if:mecanica_otro,true',
    ];

    protected $listeners = [
        'setGas',
        'setCanvas',
        'createInventario',
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
        $this->validate();

        $this->emit('create-inventario');
        // $this->emit('ok');


    }

    public function createInventario($b64){
        $diagramaB64 = $b64;

        EntradaInventario::create([
          'user_id' => Auth::id(),
          'cliente' => $this->cliente,
          'telefono' => $this->telefono,
          'marca' => $this->marca,
          'modelo' => $this->modelo,
          'year' => $this->year,
          'kilometros' => $this->kilometros,
          'color' => $this->color,
          'placas' => $this->placas,
          'notas' => $this->notas,
          'gasolina' => $this->gasolina,
          'inventario' => json_encode([
            'estereo' => $this->estereo,
            'tapetes' => $this->tapetes,
            'parabrisas' => $this->parabrisas,
            'gato' => $this->gato,
            'extra' => $this->extra,
            'herramientas' => $this->herramientas,
            'cables' => $this->cables,
          ]),
          'testigos' => json_encode([
            'abs' => $this->abs,
            'check_engine' => $this->check_engine,
            'antiderrapante' => $this->antiderrapante,
            'brake' => $this->brake,
            'bolsas' => $this->bolsas,
            'stability_track' => $this->stability_track,
          ]),
          'carroceria' => json_encode([
            'puertas' => [
              'puertas_1' => $this->puertas_1,
              'puertas_2' => $this->puertas_2,
              'puertas_3' => $this->puertas_3,
              'puertas_4' => $this->puertas_4,
              'puertas_5' => $this->puertas_5,
            ],
            'costados' => [
              'costados_izquierdo' => $this->costados_izquierdo,
              'costados_derecho' => $this->costados_derecho,
            ],
            'piso_cajuela' => $this->piso_cajuela,
            'tolva_escape' => $this->tolva_escape,
            'capacete' => $this->capacete,
            'cofre' => $this->cofre,
            'rep_granizo' => $this->rep_granizo,
            'pintura_general' => $this->pintura_general,
            'fender' => [
              'fender_izquierdo' => $this->fender_izquierdo,
              'fender_derecho' => $this->fender_derecho,
            ],
            'facia' => [
              'facia_delantera' => $this->facia_delantera,
              'facia_trasera' => $this->facia_trasera,
            ],
            'carroceria_otro' => $this->carroceria_otro,
            'carroceria_otro_text' => $this->carroceria_otro_text,
          ]),
          'mecanica' => json_encode([
            'afinacion_mayor' => $this->afinacion_mayor,
            'cambio_aceite' => $this->cambio_aceite,
            'falla_mecanica' => $this->falla_mecanica,
            'falla_mecanica_text' => $this->falla_mecanica_text,
            'frenos' => $this->frenos,
            'suspension' => $this->suspension,
            'suspension_text' => $this->suspension_text,
            'mecanica_otro' => $this->mecanica_otro,
            'mecanica_otro_text' => $this->mecanica_otro_text,
          ]),
          'diagrama' => $diagramaB64,

        ]);

        // $this->reset();
        $this->emit('ok','Se ha registrado Inventario');
        return redirect()->to('/inventarios');
    }

}
