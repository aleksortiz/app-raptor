<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;

class EditCliente extends Component
{
    public $cliente;
    public $activeTab;
    // public $contacso;

    protected $rules = [
        'cliente.nombre' => 'string|required|min:3|max:255',
        'cliente.abreviacion' => "string|required|min:2|max:5",
        'cliente.rfc' => 'string|nullable|min:10|max:13',
        'cliente.razon_social' => 'string|nullable|min:2|max:255',
        'cliente.calle' => 'string|nullable|min:2|max:255',
        'cliente.numero' => 'string|nullable|min:1|max:10',
        'cliente.colonia' => 'string|nullable|min:2|max:255',
        'cliente.codigo_postal' => 'string|nullable|min:4|max:12',
        'cliente.ciudad' => 'string|nullable|min:2|max:255',
        'cliente.estado' => 'string|nullable|min:2|max:255'
    ];


    public function mount($cliente)
    {
        $this->cliente = $cliente;
        $this->activeTab = 1;
    }

    public function render()
    {
        return view('livewire.cliente.edit-cliente.view');
    }

    public function save()
    {
        $this->validate([
            'cliente.abreviacion' => "string|required|min:2|max:5|unique:clientes,abreviacion,{$this->cliente->id}",
        ]);
        $this->validate();
        if($this->cliente->save()){
            $this->emit('ok', $this->cliente->nombre, 'Se ha guardado Cliente:');
        }
    }
}
