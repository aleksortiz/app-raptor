<?php

namespace App\Http\Livewire\Cliente\Common;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectCliente extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public Cliente $cliente;
    public $createMode = false;

    public $mdlName = 'mdlSelectCliente';
    public $pageName = 'selectClientePage';
    public $successAction = 'setCliente';
    public $keyWord;

    protected $listeners = [
      'initMdlSelectCliente',
    ];

    protected $rules = [
        'cliente.nombre' => 'string|required|min:3|max:255',
        'cliente.telefono' => 'string|required|min:10|max:15',
        'cliente.rfc' => 'string|nullable|min:10|max:13',
        'cliente.razon_social' => 'string|nullable|min:5|max:255',
        'cliente.calle' => 'string|nullable|min:5|max:255',
        'cliente.numero' => 'string|nullable|min:1|max:10',
        'cliente.colonia' => 'string|nullable|min:2|max:255',
        'cliente.codigo_postal' => 'string|nullable|min:4|max:12',
        'cliente.ciudad' => 'string|nullable|min:2|max:255',
        'cliente.estado' => 'string|nullable|min:2|max:255',
    ];

    public function mount(){
        $this->cliente = new Cliente();
    }

    public function initMdlSelectCliente(){
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function updatedKeyWord(){
        $this->resetPage($this->pageName);
    }

    public function render()
    {
        return view('livewire.cliente.common.mdl-select-cliente', $this->getRenderData());
    }

    public function getRenderData(){
        return [
            'clientes' => Cliente::OrderBy('nombre')
            ->orWhere('nombre', 'LIKE', "%{$this->keyWord}%")
            ->orWhere('id', $this->keyWord)
            ->orWhere('rfc', $this->keyWord)
            ->paginate(50, ['*'], 'selectClientePage'),
        ];
    }

    public function select($id){
        $this->emit($this->successAction, $id);
        $this->emit('closeModal', "#{$this->mdlName}");
    }

    public function create(){
        $this->validate();
        if($this->cliente->save()){
            $this->emit('ok', "Se ha creado cliente: {$this->cliente->nombre}");
            $this->emit($this->successAction, $this->cliente->id);
            $this->emit('closeModal', "#{$this->mdlName}");
        }
        $this->cliente = new Cliente();
        $this->createMode = false;
    }
}
