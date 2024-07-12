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
        'model.destajo' => 'boolean|required',
        'model.administrativo' => 'boolean|required',
        'model.fecha_ingreso' => 'date|nullable',
    ];

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Personal();
    }

    public function save()
    {
        if($this->model->destajo){
            $this->model->sueldo = 0;
            $this->model->administrativo = false;
        }
        else if($this->model->sueldo <= 0){
            $this->emit('info', 'El sueldo debe ser mayor a 0');
            return;
        }

        $this->validate();

        $this->model->save();
        $this->emit('ok',"Se ha guardado {$this->model_name_lower}: {$this->model->descripcion}", $this->model->codigo);
        $this->emit('closeModal', '#mdl');
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('nombre', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.personal.catalogo-personal.view', compact('data'));
    }

    public function toggleActive($id){
        $record = $this->model::find($id);
        $record->activo = !$record->activo;
        $record->save();
        $this->emit('ok');
    }
}
