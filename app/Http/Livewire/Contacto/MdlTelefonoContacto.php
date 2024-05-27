<?php

namespace App\Http\Livewire\Contacto;

use App\Models\Contacto;
use App\Models\NumeroTelefono;
use Livewire\Component;

class MdlTelefonoContacto extends Component
{
    public $contacto;
    public $telefonos;
    public $selectedTelefono;


    protected $listeners = [
        'destroyTelefono' => 'destroy'
    ];

    protected $rules = [
        'selectedTelefono.numero' => 'numeric|required|digits_between:10,15',
        'selectedTelefono.tipo' => 'string|required|max:15',
        'selectedTelefono.extension' => 'numeric|nullable|digits_between:0,6',
        'selectedTelefono.model_type' => 'string|required',
        'selectedTelefono.model_id' => 'numeric|required',
    ];

    public function mount(Contacto $contacto){
        $this->contacto = $contacto;
        $this->telefonos = $this->contacto->telefonos;

        $this->resetInput();
    }

    public function loadTelefonos(){
        $this->contacto->load('telefonos');
        $this->telefonos = $this->contacto->telefonos;
    }

    public function resetInput(){
        $this->selectedTelefono = new NumeroTelefono();
        $this->selectedTelefono->model_type = Contacto::class;
        $this->selectedTelefono->model_id = $this->contacto->id;
    }
    
    public function render()
    {
        return view('livewire.contacto.mdl-telefono-contacto');
    }

    public function save()
    {
        $this->validate();
        if($this->selectedTelefono->save()){
            // $this->emit('closeModal', '#mdlContacto');
            $this->emit('loadContactos');
            $this->resetInput();
            $this->loadTelefonos();

            // $this->contacto->load('telefonos');
        }
    }

    public function cancelEdit(){
        $this->resetInput();
        $this->loadTelefonos();
    }

    public function edit($id)
    {
        $this->deteleEmptyRow();
        $this->resetValidation();
        $this->selectedTelefono = NumeroTelefono::findOrFail($id);
    }

    public function destroy($id)
    {
        // $this->deteleEmptyRow();
        // $this->resetValidation();
        $this->selectedTelefono = NumeroTelefono::findOrFail($id);
        $this->selectedTelefono->delete();
        $this->resetInput();
        $this->loadTelefonos();

        // $this->contacto->load('telefonos');
    }

    public function addRow()
    {
        // $this->selectedTelefono = new NumeroTelefono();
        // $this->telefonos->push(new NumeroTelefono());

        $this->deteleEmptyRow();
        $this->resetInput();
        $this->telefonos->prepend($this->selectedTelefono);   
    }

    public function deteleEmptyRow()
    {
        foreach ($this->telefonos as $key => $tel) {
            if (!$tel->id) {
                $this->telefonos->pull($key);
            }
        }
    }

}
