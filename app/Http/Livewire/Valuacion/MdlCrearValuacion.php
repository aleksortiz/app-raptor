<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Cliente;
use App\Models\Valuacion;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class MdlCrearValuacion extends Component
{
    public $mdlName = 'mdlCrearValuacion';

    protected $listeners = [
      'initMdlCrearValuacion',
      'setCliente'
    ];

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
    ];

    public function test(){
        $this->numero_reporte = '123';
        $this->cliente_id = 1;
        $this->cliente_name = 'Cliente de prueba';
        $this->marca = 'Chevrolet';
        $this->modelo = 'Aveo';
        $this->year = 2010;
        $this->color = 'Rojo';
        $this->grua = true;
        $this->valuacion_efectuada = false;
        $this->notas = 'Notas de prueba';
        $this->fecha_cita = now()->format('Y-m-d\TH:i');
    }

    public function render(){
        return view('livewire.valuacion.mdl-crear-valuacion', $this->getRenderData());
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

    public function initMdlCrearValuacion($date = null){
        $this->reset();
        $this->resetValidation();
        $this->emit('showModal', "#{$this->mdlName}");
        if($date){
            $this->fecha_cita = $date;
        }
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

    public function create(){
        $this->validate();

        $valuacion = new Valuacion([
          'cliente_id' => $this->cliente_id,
          'numero_reporte' => $this->numero_reporte,
          'marca' => $this->marca,
          'modelo' => $this->modelo,
          'year' => $this->year,
          'color' => $this->color,
          'grua' => $this->grua,
          'fecha_cita' => $this->fecha_cita,
          'valuacion_efectuada' => $this->valuacion_efectuada,
          'notas' => $this->notas,
        ]);

        if($valuacion->save()){
            $this->emit('ok', 'Cita creada correctamente');
            $this->emit('closeModal', "#{$this->mdlName}");
            $this->reset();
            $this->emit('reloadCitasValuacion');
            $valuacion->vehiculo = $valuacion->vehiculo;
            $this->emit('addCalendarEvent', $valuacion->toArray());
        }
    }





}
