<?php

namespace App\Http\Livewire\Contacto\Common;

use App\Models\Contacto;
use Livewire\Component;

class BtnCreateContacto extends Component
{
    public $contacto;
    public $model_name = "Contacto";
    public $btn_color = 'btn-success';
    public $btn_icon = 'fa-plus';
    public $btn_text = 'Agregar Contacto';

    public $morphsModel;

    protected $rules = [
        'contacto.nombre' => 'string|required|min:3|max:255',
        'contacto.correo' => 'string|email|required|max:255',
        'contacto.departamento' => 'string|nullable|max:255',
        'contacto.prefijo' => 'string|nullable|max:10',
        'contacto.model_id' => 'numeric|required',
        'contacto.model_type' => 'string|required',
    ];

    public function mount($morphsModel){
        $this->morphsModel = $morphsModel;
        $this->resetInput();
    }

    public function resetInput(){
        $this->contacto = new Contacto();
        $this->contacto->model_id = $this->morphsModel->id;
        $this->contacto->model_type = get_class($this->morphsModel);
    }
    
    public function render()
    {
        return view('livewire.contacto.common.btn-save-contacto');
    }

    public function save()
    {
        // $this->validate();
        if($this->contacto->save()){
            $this->emit('ok', "Se ha guardado contacto: {$this->contacto->nombre}");
            $this->emit('closeModal', '#mdlCreateContacto');
            $this->emit('loadContactos');
            $this->resetInput();
        }
    }
    
}
