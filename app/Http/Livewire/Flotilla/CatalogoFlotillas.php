<?php

namespace App\Http\Livewire\Flotilla;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Flotilla;
use App\Models\FlotillaUnidad;

class CatalogoFlotillas extends Component
{
    use WithPagination;
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

    public function mdlCrearUnidad(){
        $this->emit('showModal', '#mdlCrearUnidad');
    }

    public function createFlotilla(){
        $this->validate([
            'nombreFlotilla' => 'string|required',
            'notasFlotilla' => 'string|nullable',
        ]);

        $this->selectedFlotilla = Flotilla::create([
            'nombre' => $this->nombreFlotilla,
            'notas' => $this->notasFlotilla,
            'cliente_id' => 1,
        ]);

        $this->nombreFlotilla = null;
        $this->notasFlotilla = null;

        $this->emit('closeModal', '#mdlCrearFlotilla');
        $this->emit('ok', 'Se ha creado flotilla');
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

    public function back(){
        $this->selectedUnidad = null;
    }
}
