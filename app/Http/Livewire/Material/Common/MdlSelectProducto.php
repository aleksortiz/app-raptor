<?php

namespace App\Http\Livewire\Producto\Common;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectProducto extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $priceField = 'precio'; // | costo
    public $stockValidation = true;
    
    public $mdlName = 'mdlSelectProducto';
    public $pageName = 'selectProductoPage';
    public $successAction = 'setProducto';
    public $keyWord;

    public $marcas;
    public $categorias;
    public $selectedMarca = "";
    public $selectedCategoria = "";

    protected $listeners = [
      'initMdlSelectProducto',
    ];

    public function mount(){
        $this->marcas = Marca::all();
        $this->categorias = Categoria::all();
    }

    public function initMdlSelectProducto(){
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function updatedKeyWord(){
        $this->resetPage($this->pageName);
    }

    public function render()
    {
        return view('livewire.producto.common.mdl-select-producto', $this->getRenderData());
    }

    public function getRenderData(){
        $data = Producto::OrderBy('descripcion');
        $data->Where('marca', 'LIKE', "%{$this->selectedMarca}%");
        $data->Where('categorias', 'LIKE', "%{$this->selectedCategoria}%");
        $data->Where(function($q){
            $q->orWhere('codigo', 'LIKE', "%{$this->keyWord}%");
            $q->orWhere('descripcion', 'LIKE', "%{$this->keyWord}%");
        });

        return [
            'data' => $data
            ->paginate(50, ['*'], $this->pageName),
        ];
    }

    public function select($id){
        $this->emit($this->successAction, $id);
        $this->emit('closeModal', "#{$this->mdlName}");
    }
}
