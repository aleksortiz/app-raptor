<?php

namespace App\Http\Livewire\Contacto;

use App\Models\Contacto;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoContactos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $model_name = "Contacto";
    protected $model_name_plural = "Contactos";

    protected $selectedContacto;
    public $keyWord;
    public $adminCan = 'NOT-ACCESS';

    public $morphsModel;

    protected $listeners = [
        'loadContactos' => 'resetInput',
        'destroyContacto' => 'destroy',
    ];

    public function updatingKeyWord(){
        $this->resetPage('pageContactos');
    }

    public function mount($morphsModel){
        $this->morphsModel = $morphsModel;
        $this->resetInput();
        $this->setPermissions();
    }

    public function setPermissions(){
        switch (get_class($this->morphsModel)) {
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

    public function resetInput() // mount in LivewireBaseCrudController
    {
        $this->resetValidation();
        $this->selectedContacto = new Contacto();
        $this->selectedContacto->model_id = $this->morphsModel->id;
        $this->selectedContacto->model_type = get_class($this->morphsModel);
    }

    public function destroy($id){
        $del = Contacto::findOrFail($id);
        if($del->SoftDelete()){
            $this->emit("Se ha eliminado contacto: {$del->nombre}");
        }
    }

    public function render()
    {
        $kw = '%' . $this->keyWord . '%';
        $contactos = Contacto::orderBy('id', 'asc')
            ->where('canceled_by', null)
            ->where('model_id', $this->morphsModel->id)
            ->where('model_type', get_class($this->morphsModel))
            ->where(function ($query) use ($kw) {
                $query->where('nombre', 'LIKE', $kw);
                $query->orWhere('correo', 'LIKE', $kw);
                $query->orWhere('departamento', 'LIKE', $kw);
            })->paginate(15, ['*'], 'pageContactos');        
        return view('livewire.contacto.catalogo-contactos.view', compact('contactos'));
    }

    
}
