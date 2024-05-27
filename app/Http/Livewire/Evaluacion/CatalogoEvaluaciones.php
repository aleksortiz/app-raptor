<?php

namespace App\Http\Livewire\Evaluacion;

use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Models\Evaluacion;
use App\Models\Fabricante;
use App\Models\Sucursal;

class CatalogoEvaluaciones extends LivewireBaseCrudController
{
    protected $model_name = "Evaluación";
    protected $model_name_plural = "Evaluaciones";
    
    protected $rules = [
        'model.no_reporte' => 'string|required|max:80',
        'model.sucursal_id' => 'numeric|required|min:1',
        'model.fabricante' => 'string|required|max:80',
        'model.modelo' => 'string|required|max:80',
        'model.notas' => 'string|nullable',
    ];

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Evaluacion();
    }

    public function render()
    {
        return view('livewire.evaluacion.catalogo-evaluaciones.view', $this->getRenderData());
    }

    public function getRenderData(){
        $keyWord = '%'.$this->keyWord .'%';

        return [
            'sucursales' => Sucursal::where('canceled_at', null)->get(),
            'fabricantes' => Fabricante::Catalog(),
            'modelos' => Entrada::CatalogoModelos(),
            'data' =>$this->model::orderBy('id', 'desc')
            ->orWhere('no_reporte', 'LIKE', $keyWord)
            ->paginate(50),
        ];
    }

    public function showPhotos($id){
        $this->model = Evaluacion::findOrFail($id);
        $this->emit('showModal', '#mdlPhotos');
    }
    
}
