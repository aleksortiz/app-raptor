<?php

namespace App\Http\Livewire\Contacto;

use App\Models\Contacto;
use Livewire\Component;

class BtnSaveContacto extends Component
{
    public $contacto;
    public $model_name = "Contacto";
    public $modalName;
    public $btn_color = 'btn-success';
    public $btn_icon = 'fa-plus';
    public $btn_text = 'Agregar Contacto';

    protected $rules = [
        'contacto.nombre' => 'string|required|min:3|max:255',
        'contacto.correo' => 'string|email|required|max:255',
        'contacto.departamento' => 'string|nullable|max:255',
        'contacto.prefijo' => 'string|nullable|max:10',
        'contacto.model_id' => 'numeric|required',
        'contacto.model_type' => 'string|required',
    ];

    public function mount($contacto){
        $this->contacto = $contacto;
        
        $this->modalName = 'mdlContacto';
        if($this->contacto->id){
            $this->modalName .= $this->contacto->id;
            $this->customizeButton();
        }
    }

    public function customizeButton(){
        $this->btn_color = 'btn-warning';
        $this->btn_icon = 'fa-edit';
        $this->btn_text = 'Editar';
    }
    
    public function render()
    {
        return view('livewire.contacto.btn-save-contacto');
    }

    public function save()
    {
        $this->validate();
        if($this->contacto->save()){
            $this->emit('ok', "Se ha guardado contacto: {$this->contacto->nombre}");
            $this->emit('closeModal');
            $this->emit('loadContactos');
            // $this->contacto = new Contacto();
        }
    }
}
