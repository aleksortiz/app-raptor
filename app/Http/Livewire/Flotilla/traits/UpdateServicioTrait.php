<?php

namespace App\Http\Livewire\Flotilla\traits;

use App\Models\ServicioFlotilla;
use Carbon\Carbon;

trait UpdateServicioTrait {

    public $selectedServicio = null;

    public $estatus_servicio;
    public $fecha_concluido;
    public $tecnico_asignado;
    public $observaciones;

    public function updatedEstatusServicio($value){
        if($this->selectedServicio->fecha_concluido === null){
            $this->fecha_concluido = $value === 'FINALIZADO' ? Carbon::now()->format('Y-m-d H:i') : null;
        }
    }
    
    public function selectServicio($id){
        $this->selectedServicio = ServicioFlotilla::findOrFail($id);
        $this->estatus_servicio = $this->selectedServicio->estatus_servicio;
        $this->fecha_concluido = $this->selectedServicio->fecha_concluido;
        $this->tecnico_asignado = $this->selectedServicio->tecnico_asignado;
        $this->observaciones = $this->selectedServicio->observaciones;
        $this->costoServicio = $this->selectedServicio->costo;

        $this->mdlUpdateServicio();
    }

    public function mdlUpdateServicio(){
        $this->emit('showModal', '#mdlUpdateServicio');
    }

    public function updateFlotillaServicio(){
        $this->validate([
            'estatus_servicio' => 'required|string|max:255',
            'fecha_concluido' => 'nullable|date',
            'tecnico_asignado' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'costoServicio' => 'numeric|required|min:0',
        ]);

        if ($this->estatus_servicio != 'FINALIZADO') {
            $this->fecha_concluido = null;
        }

        $this->selectedServicio->update([
            'estatus_servicio' => $this->estatus_servicio,
            'fecha_concluido' => $this->fecha_concluido,
            'tecnico_asignado' => $this->tecnico_asignado,
            'observaciones' => $this->observaciones,
            'costo' => $this->costoServicio,
        ]);

        $this->estatus_servicio = null;
        $this->fecha_concluido = null;
        $this->tecnico_asignado = null;
        $this->observaciones = null;
        $this->costoServicio = null;
        $this->selectedUnidad->load('servicios');

        $this->emit('closeModal', '#mdlUpdateServicio');
        $this->emit('ok', 'Se han actualizado datos');
    }
}