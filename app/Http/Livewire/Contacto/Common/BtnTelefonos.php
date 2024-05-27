<?php

namespace App\Http\Livewire\Contacto\Common;

use App\Models\Contacto;
use App\Models\NumeroTelefono;
use Livewire\Component;

class BtnTelefonos extends Component
{
    public $contacto;
    public $telefonos;
    public $selectedTelefono;
    public $modalName = 'mdlTelefonos';

    public $btn_color = 'btn-primary';
    public $btn_icon = 'fa-phone';

    public $adminCan = 'NOT-ACCESS';

    protected function getListeners() {
        return [
            "deletePhone{$this->contacto->id}" => 'destroy'
        ];
    }

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

        if($this->contacto->id){
            $this->modalName .= $this->contacto->id;
        }

        $this->resetInput();
        $this->setPermissions();
    }

    public function setPermissions(){
        switch (get_class($this->contacto->model)) {
            case 'App\\Models\\Proveedor':
                $this->adminCan = 'administrar-proveedores';
                break;
            
            case 'App\\Models\\Cliente':
                $this->adminCan = 'administrar-clientes';
                break;

            case 'App\\Models\\Contratista':
                $this->adminCan = 'administrar-contratistas';
                break;
        }
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
        return view('livewire.contacto.common.btn-telefonos');
    }

    public function save()
    {
        $this->validate();
        if($this->selectedTelefono->save()){
            $this->emit('loadContactos');
            $this->resetInput();
            $this->loadTelefonos();
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
        $item = NumeroTelefono::findOrFail($id);
        if($item->delete())
        {
            $this->resetInput();
            $this->loadTelefonos();
        }
    }

    public function addRow()
    {
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
