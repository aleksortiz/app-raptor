<?php

namespace App\Http\Livewire\Material\Common;

use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;

class SelectMaterial extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyWord;
    public $selectedMaterial;
    public $catalogoProveedores = false;
    public $cantidad;

    public $material;

    public $createMode = false;

    public function rules()
    {
        return [
            'material.numero_parte' => "string|nullable|min:3|max:255|unique:materiales,numero_parte,{$this->material->id}",
            'material.categoria' => 'string|required|min:3|max:255',
            'material.descripcion' => 'string|required|min:5|max:255',
            'material.unidad_medida' => 'string|required|min:2|max:10',
            'material.precio' => 'numeric|required|min:0',
            'material.existencia' => 'numeric|required',
            'material.comentarios' => 'string|nullable',
        ];
    }

    public function mount()
    {
        $this->material = new Material();
    }

    public function getQtyProperty()
    {
        if ($this->cantidad) {
            return $this->cantidad;
        }
        return 0;
    }

    public function updatingKeyWord()
    {
        $this->resetPage('materialPage');
    }

    public function render()
    {
        return view('livewire.material.common.select-material', [
            'materiales' => Material::orderBy('descripcion', 'asc')
                ->where('active', true)
                ->where(function ($q) {
                    $q->orWhere('numero_parte', 'like', "%{$this->keyWord}%")
                        ->orWhere('descripcion', 'like', "%{$this->keyWord}%");
                })
                ->paginate(50, ['*'], 'materialPage'),
        ]);
    }

    public function mdlQty($id)
    {
        $this->cantidad = null;
        $this->material = new Material();
        $this->selectedMaterial = Material::findOrFail($id);
        $this->emit('closeModal', '#mdlCatalogoMateriales');
        $this->emit('showModal', '#mdlCantidadMaterial');
    }

    public function setMaterial()
    {
        $this->validate([
            'cantidad' => "required|numeric|min:0|max:{$this->selectedMaterial->existencia}",
        ]);
        $this->emit('setMaterial', $this->selectedMaterial->id, $this->cantidad);
        $this->emit('closeModal', '#mdlCantidadMaterial');
    }

    public function createMaterial()
    {
        $this->validate();
        $this->material->save();
        $this->mdlQty($this->material->id);
    }
}
