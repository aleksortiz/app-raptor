<?php

namespace App\Http\Livewire\Marca;

use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Marca;

class CatalogoMarcas extends LivewireBaseCrudController
{
    protected $model_name = "Marca";
    protected $model_name_plural = "Marcas";

    protected $rules = [
        'model.nombre' => 'string|required|max:255',
    ];

    public function save(){
        $this->validate([
            'model.nombre' => "unique:marcas,nombre,{$this->model->id}",
        ]);
        Parent::save();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Marca();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.marca.catalogo-marcas.view', compact('data'));
    }
}
