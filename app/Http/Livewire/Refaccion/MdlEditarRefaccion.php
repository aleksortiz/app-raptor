<?php

namespace App\Http\Livewire\Refaccion;

use App\Models\Refaccion2;
use Livewire\Component;

class MdlEditarRefaccion extends Component
{
    public $mdlName = 'mdlEditarRefaccion';
    public Refaccion2 $refaccion;
    public $estado;
    public $costo;
    public $precio;

    protected $rules = [
        'estado' => 'required|string|max:255',
        'costo' => 'nullable|numeric|min:0',
        'precio' => 'nullable|numeric|min:0',
    ];

    public function mount($refaccion_id)
    {
        $this->refaccion = Refaccion2::findOrFail($refaccion_id);
        $this->estado = $this->refaccion->estado;
        $this->costo = $this->refaccion->costo;
        $this->precio = $this->refaccion->precio;
    }

    public function updatedEstado($value)
    {
        if ($value !== 'VENTA') {
            $this->costo = null;
            $this->precio = null;
        }
    }

    public function save()
    {
        $this->validate();
        $this->refaccion->estado = $this->estado;
        if ($this->estado === 'VENTA') {
            $this->refaccion->costo = $this->costo;
            $this->refaccion->precio = $this->precio;
        } else {
            $this->refaccion->costo = null;
            $this->refaccion->precio = null;
        }
        $this->refaccion->save();
        $this->emit('ok', 'Refacción actualizada correctamente');
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emitUp('reloadRefacciones');
    }

    public function render()
    {
        return view('livewire.refaccion.mdl-editar-refaccion');
    }
} 