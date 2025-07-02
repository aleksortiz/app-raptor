<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Cliente;
use App\Models\Valuacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class EditarValuacion extends Component
{

    protected $listeners = [
      'setCliente'
    ];

    public $valuacion;

    public $numero_reporte;
    public $cliente_id;
    public $cliente_name;
    public $marca;
    public $modelo;
    public $year;
    public $color;
    public $grua = false;
    public $valuacion_efectuada = false;
    public $fecha_cita;
    public $notas;
    public $pago_danos;

    protected $rules = [
        'numero_reporte' => 'required|digits:11',
        'cliente_id' => 'required',
        'marca' => 'required',
        'modelo' => 'required',
        'year' => 'required|numeric|min:1900',
        'color' => 'nullable|max:255',
        'grua' => 'required|boolean',
        'valuacion_efectuada' => 'required|boolean',
        'fecha_cita' => 'nullable|date',
        'notas' => 'nullable|max:255',
        'pago_danos' => 'required|boolean',
    ];

    public function mount($id){
        $valuacion = Valuacion::findOrfail($id);
        $this->numero_reporte = $valuacion->numero_reporte;
        $this->cliente_id = $valuacion->cliente_id;
        $this->cliente_name = $valuacion->cliente->nombre;
        $this->marca = $valuacion->marca;
        $this->modelo = $valuacion->modelo;
        $this->year = $valuacion->year;
        $this->color = $valuacion->color;
        $this->grua = $valuacion->grua;
        $this->valuacion_efectuada = $valuacion->valuacion_efectuada;
        $this->fecha_cita = $valuacion->fecha_cita;
        $this->notas = $valuacion->notas;
        $this->pago_danos = $valuacion->pago_danos;
        $this->valuacion = $valuacion;
    }


    public function render(){
        return view('livewire.valuacion.editar-valuacion', $this->getRenderData());
    }

    public function getRenderData(){
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);

        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
        ];
    }

    public function setCliente($id){
        if(!$id){
            $this->cliente_id = null;
            $this->cliente_name = null;
            return;
        }

        $cliente = Cliente::findOrfail($id);
        $this->cliente_id = $cliente->id;
        $this->cliente_name = $cliente->nombre;
    }

    public function save(){

        if(!$this->fecha_cita){
            $this->fecha_cita = null;
        }
        
        $this->validate();

        $this->valuacion->numero_reporte = $this->numero_reporte;
        $this->valuacion->cliente_id = $this->cliente_id;
        $this->valuacion->marca = $this->marca;
        $this->valuacion->modelo = $this->modelo;
        $this->valuacion->year = $this->year;
        $this->valuacion->color = $this->color;
        $this->valuacion->grua = $this->grua;
        $this->valuacion->valuacion_efectuada = $this->valuacion_efectuada;
        $this->valuacion->fecha_cita = $this->fecha_cita;
        $this->valuacion->notas = $this->notas;
        $this->valuacion->pago_danos = $this->pago_danos;
        


        if($this->valuacion->save()){
            $this->emit('ok', 'Datos guardados correctamente');
            // $this->emit('reloadCitasValuacion');
        }
    }





}
