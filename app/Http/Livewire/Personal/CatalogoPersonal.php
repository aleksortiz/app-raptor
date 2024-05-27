<?php

namespace App\Http\Livewire\Personal;

use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Personal;

class CatalogoPersonal extends LivewireBaseCrudController
{
    protected $model_name = "Personal";
    protected $model_name_plural = "Personal";

    protected $rules = [
        'model.nombre' => 'string|required|max:255',
        'model.sueldo' => 'numeric|required|min:0|max:999999.99',
        'model.telefono' => 'string|nullable|min:10|max:15',
        'model.domicilio' => 'string|nullable|max:255',
        'model.contacto_emergencia' => 'string|nullable|max:255',
        'model.notas' => 'string|nullable|max:255',
    ];

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Personal();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('nombre', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.personal.catalogo-personal.view', compact('data'));
    }
}
