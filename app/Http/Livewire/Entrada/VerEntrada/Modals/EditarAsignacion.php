<?php

namespace App\Http\Livewire\Entrada\VerEntrada\Modals;

use Livewire\Component;
use App\Models\Personal;
use App\Models\Asignacion;

class EditarAsignacion extends Component
{
    public $asignacion_id;
    public $personal_id = '';
    public $descripcion_trabajo = '';
    public $estado = 'pendiente';
    public $fecha_realizado;
    public $personal_list;

    // protected $listeners = ['showModal'];

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

    public function mount()
    {
        $this->personal_list = Personal::where('activo', true)->orderBy('nombre')->get();
    }

    public function showModal($asignacion_id)
    {
        $this->asignacion_id = $asignacion_id;
        $asignacion = Asignacion::findOrFail($asignacion_id);
        
        $this->personal_id = $asignacion->personal_id;
        $this->descripcion_trabajo = $asignacion->descripcion_trabajo;
        $this->estado = $asignacion->estado;
        $this->fecha_realizado = $asignacion->fecha_realizado ? $asignacion->fecha_realizado->format('Y-m-d H:i') : null;
        
        $this->dispatchBrowserEvent('show-mdl-editar-asignacion');
    }

    public function actualizar()
    {
        $this->validate();

        $asignacion = Asignacion::findOrFail($this->asignacion_id);
        
        $asignacion->update([
            'personal_id' => $this->personal_id,
            'descripcion_trabajo' => $this->descripcion_trabajo,
            'estado' => $this->estado,
            'fecha_realizado' => $this->estado === 'completado' ? $this->fecha_realizado : null,
        ]);

        $this->dispatchBrowserEvent('hide-mdl-editar-asignacion');
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Asignación actualizada correctamente']);
        $this->emitTo('entrada.ver-entrada', 'refresh');
    }

    public function render()
    {
        return view('livewire.entrada.ver-entrada.modals.mdl-editar-asignacion');
    }
}
