<?php

namespace App\Http\Livewire\Entrada\VerEntrada\Modals;

use Livewire\Component;
use App\Models\Personal;
use App\Models\Asignacion;
use App\Models\Entrada;

class CrearAsignacion extends Component
{
    public $entrada_id;
    public $personal_id = '';
    public $descripcion_trabajo = '';
    public $estado = 'pendiente';
    public $fecha_realizado;
    public $personal_list;

    protected $listeners = ['showModalAsignacion' => 'showModal'];

    protected $rules = [
        'personal_id' => 'required|exists:personal,id',
        'descripcion_trabajo' => 'required|string|min:10',
        'estado' => 'required|in:pendiente,en_proceso,completado',
        'fecha_realizado' => 'nullable|required_if:estado,completado|date',
    ];

    protected $messages = [
        'personal_id.required' => 'Debe seleccionar al personal',
        'descripcion_trabajo.required' => 'La descripción del trabajo es requerida',
        'descripcion_trabajo.min' => 'La descripción debe tener al menos 10 caracteres',
        'fecha_realizado.required_if' => 'La fecha de realización es requerida cuando el estado es completado',
    ];

    public function mount($entrada_id = null)
    {
        $this->entrada_id = $entrada_id;
        $this->personal_list = Personal::where('activo', true)->orderBy('nombre')->get();
    }

    public function showModal($entrada_id = null)
    {
        if ($entrada_id) {
            $this->entrada_id = $entrada_id;
        }
        $this->resetExcept(['entrada_id', 'personal_list']);
        $this->dispatchBrowserEvent('show-mdl-crear-asignacion');
    }

    public function guardar()
    {
        $this->validate();

        $entrada = Entrada::findOrFail($this->entrada_id);
        
        $asignacion = $entrada->asignaciones()->create([
            'personal_id' => $this->personal_id,
            'descripcion_trabajo' => $this->descripcion_trabajo,
            'estado' => $this->estado,
            'fecha_realizado' => $this->estado === 'completado' ? $this->fecha_realizado : null,
        ]);

        $this->dispatchBrowserEvent('hide-mdl-crear-asignacion');
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Asignación creada correctamente']);
        $this->emitTo('entrada.ver-entrada', 'refresh');
        
        $this->reset(['personal_id', 'descripcion_trabajo', 'estado', 'fecha_realizado']);
    }

    public function render()
    {
        return view('livewire.entrada.ver-entrada.modals.mdl-crear-asignacion');
    }
}
