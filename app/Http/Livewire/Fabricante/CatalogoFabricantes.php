<?php

namespace App\Http\Livewire\Fabricante;

use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Fabricante;

class CatalogoFabricantes extends LivewireBaseCrudController
{
    protected $model_name = "Fabricante";
    protected $model_name_plural = "Fabricantes";

    protected $rules = [
        'model.nombre' => 'string|required|max:255',
    ];

    public function save(){
        $this->validate([
            'model.nombre' => "unique:fabricantes,nombre,{$this->model->id}",
        ]);
        Parent::save();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Fabricante();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.fabricante.catalogo-fabricantes.view', compact('data'));
    }
}
