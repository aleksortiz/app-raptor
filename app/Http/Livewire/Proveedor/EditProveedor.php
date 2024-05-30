<?php

namespace App\Http\Livewire\Proveedor;

use Livewire\Component;

class EditProveedor extends Component
{
    public $proveedor;
    public $activeTab;
    // public $contacso;

    protected $rules = [
        'proveedor.nombre' => 'string|required|min:3|max:255',
        'proveedor.rfc' => 'string|nullable|min:10|max:13',
        'proveedor.razon_social' => 'string|nullable|min:2|max:255',
        'proveedor.calle' => 'string|nullable|min:2|max:255',
        'proveedor.numero' => 'string|nullable|min:1|max:10',
        'proveedor.colonia' => 'string|nullable|min:2|max:255',
        'proveedor.codigo_postal' => 'string|nullable|min:4|max:12',
        'proveedor.ciudad' => 'string|nullable|min:2|max:255',
        'proveedor.estado' => 'string|nullable|min:2|max:255',
        'proveedor.telefono' => 'string|nullable|min:10|max:15',
        'proveedor.correo' => 'string|nullable|min:5|max:255',
    ];


    public function mount($proveedor)
    {
        $this->proveedor = $proveedor;
        $this->activeTab = 1;
    }

    public function render()
    {
        return view('livewire.proveedor.edit-proveedor.view');
    }

    public function save()
    {
        $this->validate();
        if($this->proveedor->save()){
            $this->emit('ok', "Se ha guardado {$this->proveedor->nombre}");
        }
    }
}
