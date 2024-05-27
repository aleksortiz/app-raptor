<?php

namespace App\Http\Livewire\Aseguradora;

use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Aseguradora;

class CatalogoAseguradoras extends LivewireBaseCrudController
{
    protected $model_name = "Aseguradora";
    protected $model_name_plural = "Aseguradoras";
    
    protected $rules = [
        'model.nombre' => 'string|required|max:255',
    ];

    public function save(){
        $this->validate([
            'model.nombre' => "unique:aseguradoras,nombre,{$this->model->id}",
        ]);
        Parent::save();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Aseguradora();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.aseguradora.catalogo-aseguradoras.view', compact('data'));
    }
}
