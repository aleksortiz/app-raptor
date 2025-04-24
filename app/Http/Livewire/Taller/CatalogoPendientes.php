<?php

namespace App\Http\Livewire\Taller;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;

class CatalogoPendientes extends Component
{

    public $user_id;
    public $fecha_promesa;
    public $descripcion;

    public $weekStart;
    public $weekEnd;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->fecha_promesa = Carbon::now()->addHour(2)->setMinute(0)->setSecond(0)->toDateTimeString();
        $this->weekStart = Carbon::now()->startOfWeek()->week();
        $this->weekEnd = $this->weekStart;
    }

    public function getTiempoRestanteProperty(){
        if (!$this->fecha_promesa) {
            return null;
        }
    
        $fecha = Carbon::parse($this->fecha_promesa);
        $ahora = Carbon::now();
    
        if ($fecha->lessThan($ahora)) {
            return 'No válido';
        }
    
        $diff = $ahora->diff($fecha);
    
        $dias = $diff->d;
        $horas = $diff->h;
        $minutos = $diff->i;
    
        $partes = [];
    
        if ($dias > 0) {
            $partes[] = $dias . ' ' . Str::plural('día', $dias);
        }
    
        if ($horas > 0) {
            $partes[] = $horas . ' ' . Str::plural('Hora', $horas);
        }
    
        // Solo mostrar minutos si faltan menos de 3 horas en total
        if ($dias === 0 && $diff->h < 3 && $minutos > 0) {
            $partes[] = $minutos . ' Mins';
        }
    
        return 'Dentro de ' . implode(' y ', $partes);
    }
    
    public function crearPendiente(){
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'fecha_promesa' => 'required|date|after:now',
            'descripcion' => 'required|string|max:255',
        ]);

        \App\Models\Pendiente::create([
            'user_id' => $this->user_id,
            'fecha_promesa' => $this->fecha_promesa,
            'descripcion' => $this->descripcion,
        ]);
        $this->fecha_promesa = Carbon::now()->addHour(2)->setMinute(0)->setSecond(0)->toDateTimeString();

        $this->reset(['user_id', 'fecha_promesa', 'descripcion']);
        $this->emit('closeModal','#mdlCrearPendiente');
        $this->emit('ok', 'Pendiente creado con éxito');


    }

    public function render()
    {
        return view('livewire.taller.catalogo-pendientes.view', $this->getRenderData());
    }

    public function getUsers()
    {
        return \App\Models\User::paginate();
    }

    public function getPendientes()
    {
        return \App\Models\Pendiente::paginate();
    }

    public function getRenderData()
    {
        return [
            'pendientes' => $this->getPendientes(),
            'users' => $this->getUsers(),
        ];
    }

    public function getFechaPromesaProperty()
    {
        return Carbon::parse($this->fecha_promesa)->format('Y-m-d H:i:s');
    }

}
