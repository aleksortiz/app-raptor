<?php

namespace App\Http\Livewire\Personal;

use App\Models\Entrada;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use Livewire\Component;

class MdlCrearOrdenTrabajo extends Component
{
    public $monto = 0;
    public $notas;
    public $entrada;
    public $personal;
    public $keyWord;
    public $personal_id;


    public $haveEntrada = false;

    protected $rules = [
        'monto' => 'required|numeric|gt:0',
        'notas' => 'string|nullable|max:255',
        'personal_id' => 'required|numeric|gt:0',
    ];

    public function mount($entrada_id = null)
    {
        if ($entrada_id) {
            $this->haveEntrada = true;
            $this->entrada = Entrada::FindOrFail($entrada_id);
        }
    }


    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $catalogo_personal = Personal::orderBy('nombre', 'ASC')
        ->where('activo', true)
        ->where('destajo', true)
        ->where('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.personal.mdl-crear-orden-trabajo.view', compact('catalogo_personal'));
    }

    public function crearOrden()
    {
        $this->personal_id = $this->personal?->id ?? null;
        $this->validate();
        OrdenTrabajo::create([
            'user_id' => auth()->id(),
            'entrada_id' => $this->entrada->id,
            'personal_id' => $this->personal->id,
            'monto' => $this->monto,
            'notas' => $this->notas,
        ]);
        $this->monto = 0;
        $this->notas = '';
        $this->personal = null;
        if (!$this->haveEntrada) {
            $this->entrada = null;
        }
        
        $this->emit('ok', 'Se ha creado la orden de trabajo correctamente.');
        $this->emit('closeModal', '#mdlCreateWorkOrder');
        $this->emit('reload');
    }

    public function selectPersonal($id)
    {
        $this->personal = Personal::FindOrFail($id);
        $this->emit('closeModal', '#mdlSelectPersonal');

    }
}
