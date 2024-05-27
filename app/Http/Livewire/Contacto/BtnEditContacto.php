<?php

namespace App\Http\Livewire\Contacto;

use App\Models\Contacto;
use Livewire\Component;

class BtnEditContacto extends Component
{
    public Contacto $contacto;

    public $open = false;

    protected $rules = [
        'contacto.nombre' => 'string|required|min:3|max:255',
        'contacto.correo' => 'string|email|required|max:255',
        'contacto.departamento' => 'string|nullable|max:255',
        'contacto.prefijo' => 'string|nullable|max:10',
    ];

    public function mount(){
        // $this->contacto = $this->model;
    }
    
    public function mdl($id)
    {
        // $this->emit('alert', $id);
        // $this->resetValidation();
        // $this->contacto = Contacto::findOrFail($id);
        $this->emit('$refresh');
        $this->emit('refreshComponent');      
        $this->emit('showModal', '#mdlBtnEdit');
    }

    public function render()
    {
        $this->emit('console', $this->contacto);
        return view('livewire.contacto.btn-edit-contacto');
    }
}
