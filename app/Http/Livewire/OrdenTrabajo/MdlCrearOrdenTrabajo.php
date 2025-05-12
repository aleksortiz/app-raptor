<?php

namespace App\Http\Livewire\OrdenTrabajo;

use App\Models\Entrada;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use Livewire\Component;

class MdlCrearOrdenTrabajo extends Component
{
    public $mdlName = 'mdlCrearOrdenTrabajo';

    protected $listeners = [
        'initMdlCrearOrdenTrabajo',
        'setEntrada'
    ];

    public $entrada_id;
    public $entrada;
    public $personal_id;
    public $monto;
    public $notas;
    public $costo_id;

    protected $rules = [
        'entrada_id' => 'required|numeric',
        'personal_id' => 'required|numeric',
        'monto' => 'required|numeric|min:0',
        'notas' => 'nullable|string|max:255',
        'costo_id' => 'nullable|numeric'
    ];

    public function render()
    {
        return view('livewire.orden-trabajo.mdl-crear-orden-trabajo', $this->getRenderData());
    }

    public function getRenderData()
    {
        $personal = Personal::orderBy('nombre', 'ASC')
            ->where('activo', true)
            ->where('destajo', true)
            ->get();

        return [
            'personal' => $personal
        ];
    }

    public function initMdlCrearOrdenTrabajo($entrada_id = null)
    {
        $this->reset();
        $this->resetValidation();
        if ($entrada_id) {
            $this->setEntrada($entrada_id);
        }
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function setEntrada($id)
    {
        if (!$id) {
            $this->entrada_id = null;
            $this->entrada = null;
            return;
        }

        $entrada = Entrada::findOrFail($id);
        $this->entrada_id = $entrada->id;
        $this->entrada = $entrada;
    }

    public function create()
    {
        $this->validate();

        $ordenTrabajo = new OrdenTrabajo([
            'user_id' => auth()->id(),
            'entrada_id' => $this->entrada_id,
            'personal_id' => $this->personal_id,
            'monto' => $this->monto,
            'notas' => $this->notas,
            'porcentaje' => 0,
            'costo_id' => $this->costo_id
        ]);

        if ($ordenTrabajo->save()) {
            $this->emit('ok', 'Orden de trabajo creada correctamente');
            $this->emit('closeModal', "#{$this->mdlName}");
            $this->reset();
            $this->emit('reloadOrdenesTrabajo');
        }
    }
} 