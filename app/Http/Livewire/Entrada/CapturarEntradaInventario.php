<?php

namespace App\Http\Livewire\Entrada;

use App\Models\CitaReparacion;
use App\Models\Entrada;
use App\Models\EntradaInventario;
use App\Models\Fabricante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CapturarEntradaInventario extends Component
{
    public $firmar = false;

    public $cita;
    public $folioCita;
    public $entradaId;
    public $entrada;
    public $cliente;
    public $vehiculo;

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

    protected $queryString = [
        'folioCita',
        'entradaId'
    ];

    protected $rules = [
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

    public function mount(){
      $this->entrada = Entrada::find($this->entradaId);
      if($this->entrada){
        $this->cita = new CitaReparacion([
          'cliente_id' => $this->entrada->cliente_id,
          'marca' => $this->entrada->fabricante->nombre,
          'modelo' => $this->entrada->modelo,
          'no_reporte' => $this->entrada->orden,
          'cliente_id' => $this->entrada->cliente_id,
          'cita' => now(),
        ]);
        $this->cliente = $this->entrada->cliente;
        $this->vehiculo = $this->entrada->vehiculo;
        $this->year = $this->entrada->year;
        $this->color = $this->entrada->color;
        return;
      }
      $this->entradaId = null;
      $this->entrada = null;

      $this->cita = CitaReparacion::find($this->folioCita);
      $this->cliente = $this->cita->cliente;
      $this->vehiculo = $this->cita->vehiculo;
      $this->year = $this->cita->valuacion->year;
      $this->color = $this->cita->valuacion->color;
      if(!$this->cita || $this->cita->inventario_id){
        abort(404, 'Cita no encontrada');
      }
    }

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
    }

    public function createInventario($b64){
        $diagramaB64 = $b64;

        $inventario = EntradaInventario::create([
          'user_id' => Auth::id(),
          'cliente' => $this->cliente->nombre,
          'telefono' => $this->cliente->telefono,
          'marca' => $this->cita->marca,
          'modelo' => $this->cita->modelo,
          'year' => $this->year,
          'kilometros' => $this->kilometros,
          'color' => trim(strtoupper($this->color)),
          'placas' => trim(strtoupper($this->placas)),
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

        $this->cita->inventario_id = $inventario->id;
        if($this->entrada){
          $this->cita->cliente_id = $this->cliente->id;
        }
        $this->cita->save();

        $fabricante = $this->cita->marca;

        if(!$this->entrada){
          $this->entrada = Entrada::create([
            'user_id' => Auth::id(),
            'sucursal_id' => 1,
            'aseguradora_id' => 1,
            'fabricante_id' => 1,
            'marca' => $fabricante,
            'cliente_id' => $this->cita->cliente_id,
            'origen' => 'ASEGURADORA',
            'modelo' => $this->cita->modelo,
            'orden' => $this->cita->no_reporte,
            'rfc' => $this->cita->cliente->rfc,
            'razon_social' => $this->cita->cliente->razon_social,
            'domicilio_fiscal' => $this->cita->cliente->codigo_postal,
          ]);
        }



        $inventario->entrada_id = $this->entrada->id;
        $inventario->save();

        $this->emit('ok','Se ha registrado Inventario');
        return redirect()->to("/inventarios/$inventario->id/tomar-fotos");
    }

}
