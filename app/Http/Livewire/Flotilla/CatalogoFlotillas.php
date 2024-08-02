<?php

namespace App\Http\Livewire\Flotilla;

use App\Http\Livewire\Flotilla\traits\FotosServicioTrait;
use App\Http\Livewire\Flotilla\traits\UpdateServicioTrait;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Flotilla;
use App\Models\FlotillaUnidad;
use App\Models\ServicioFlotilla;
use Carbon\Carbon;

class CatalogoFlotillas extends Component
{
    use WithPagination, UpdateServicioTrait, FotosServicioTrait;

    protected $paginationTheme = 'bootstrap';

    public $selectedFlotilla = null;
    public $selectedUnidad = null;

    public $cliente;
    public $nombreFlotilla;
    public $notasFlotilla;

    public $fabricanteUnidad;
    public $modeloUnidad;
    public $yearUnidad;
    public $serieUnidad;
    public $placasUnidad;
    public $kilometrajeUnidad;

    public $tipoServicio;
    public $descripcionServicio;
    public $costoServicio;
    public $fechaServicio;
    public $ubicacionServicio;


    public function mount($identificador){
        $this->cliente = Cliente::where('identificador', $identificador)->first();
        if(!$this->cliente){
            abort(404);
        }
    }

    public function render(){
        return view('livewire.flotilla.catalogo-flotillas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $flotillas = Flotilla::orderBy('id', 'desc')
        ->where('cliente_id', $this->cliente->id);

        return [
            'flotillas' => $flotillas->paginate(50),
        ];
    }

    public function selectFlotilla($id){
        $this->selectedFlotilla = Flotilla::findOrFail($id);
    }

    public function selectUnidad($id){
        $this->selectedUnidad = FlotillaUnidad::findOrFail($id);
    }

    public function mdlCrearFlotilla(){
        $this->emit('showModal', '#mdlCrearFlotilla');
    }

    public function createFlotilla(){
        $this->validate([
            'nombreFlotilla' => 'string|required',
            'notasFlotilla' => 'string|nullable',
        ]);

        $this->selectedFlotilla = Flotilla::create([
            'nombre' => $this->nombreFlotilla,
            'notas' => $this->notasFlotilla,
            'cliente_id' => $this->cliente->id,
        ]);

        $this->nombreFlotilla = null;
        $this->notasFlotilla = null;

        $this->emit('closeModal', '#mdlCrearFlotilla');
        $this->emit('ok', 'Se ha creado flotilla');
    }
    
    public function mdlCrearUnidad(){
        $this->emit('showModal', '#mdlCrearUnidad');
    }

    public function createFlotillaUnidad(){
        $this->validate([
            'fabricanteUnidad' => 'string|required',
            'modeloUnidad' => 'string|required',
            'yearUnidad' => 'numeric|required|min:1900',
            'serieUnidad' => 'string|nullable',
            'placasUnidad' => 'string|nullable',
            'kilometrajeUnidad' => 'numeric|required|min:0',
        ]);

        FlotillaUnidad::create([
            'flotilla_id' => $this->selectedFlotilla->id,
            'fabricante' => $this->fabricanteUnidad,
            'modelo' => $this->modeloUnidad,
            'year' => $this->yearUnidad,
            'serie' => $this->serieUnidad,
            'placas' => $this->placasUnidad,
            'kilometraje' => $this->kilometrajeUnidad,
        ]);

        $this->fabricanteUnidad = null;
        $this->modeloUnidad = null;
        $this->yearUnidad = null;
        $this->serieUnidad = null;
        $this->placasUnidad = null;
        $this->kilometrajeUnidad = null;

        $this->selectedFlotilla->load('unidades');

        $this->emit('closeModal', '#mdlCrearUnidad');
        $this->emit('ok', 'Se ha creado unidad');
    }

    public function mdlCrearServicio(){
        $this->TEST(); //TODO quitar
        $this->emit('showModal', '#mdlCrearServicio');
    }

    public function createFlotillaServicio(){
        $this->validate([
            'tipoServicio' => 'string|required',
            'descripcionServicio' => 'string|required',
            'costoServicio' => 'numeric|min:0|required',
            'fechaServicio' => 'date|required',
            'ubicacionServicio' => 'string|required',
        ]);

        ServicioFlotilla::create([
            'flotilla_unidad_id' => $this->selectedUnidad->id,
            'tipo_servicio' => $this->tipoServicio,
            'descripcion' => $this->descripcionServicio,
            'fecha_servicio' => $this->fechaServicio,
            'costo' => $this->costoServicio,
            'ubicacion' => $this->ubicacionServicio,
        ]);

        $this->tipoServicio = null;
        $this->descripcionServicio = null;
        $this->costoServicio = null;
        $this->fechaServicio = null;
        $this->ubicacionServicio = null;

        $this->selectedUnidad->load('servicios');

        $this->emit('closeModal', '#mdlCrearServicio');
        $this->emit('ok', 'Se ha registrado servicio');
    }

    public function back(){
        $this->selectedUnidad = null;
    }

    public function TEST(){
        $this->tipoServicio = "Cambio de aceite";
        $this->descripcionServicio = "5 Litros de aceite QUAKER 50w-40";
        $this->costoServicio = 500;
        $this->fechaServicio = Carbon::now();
        $this->ubicacionServicio = "Lopez Mateos y Ejercito Nacional, frente a edificio azul";
    }
}
