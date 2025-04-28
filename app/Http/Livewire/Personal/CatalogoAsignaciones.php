<?php

namespace App\Http\Livewire\Personal;

use Livewire\Component;
use App\Models\Asignacion;
use Carbon\Carbon;
use Livewire\WithPagination;

class CatalogoAsignaciones extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $semana;
    public $estado = '';
    public $semanas = [];

    protected $queryString = ['semana', 'estado'];

    public function mount()
    {
        // Generar lista de semanas (últimas 4 semanas)
        $now = Carbon::now();
        $this->semanas = collect(range(0, 3))->mapWithKeys(function ($weeks) use ($now) {
            $start = $now->copy()->subWeeks($weeks)->startOfWeek();
            $end = $start->copy()->endOfWeek();
            $key = $start->format('Y-m-d');
            $value = "Semana del " . $start->format('d/m/Y') . " al " . $end->format('d/m/Y');
            return [$key => $value];
        })->all();

        // Si no hay semana seleccionada, usar la semana actual
        if (!$this->semana) {
            $this->semana = $now->startOfWeek()->format('Y-m-d');
        }
    }

    public function getAsignacionesProperty()
    {
        $query = Asignacion::with(['personal', 'entrada'])
            ->whereBetween('created_at', [
                Carbon::parse($this->semana),
                Carbon::parse($this->semana)->endOfWeek()
            ]);

        if ($this->estado) {
            $query->where('estado', $this->estado);
        }

        return $query->orderBy('created_at', 'desc')
                    ->paginate(15);
    }

    public function render()
    {
        return view('livewire.personal.catalogo-asignaciones', [
            'asignaciones' => $this->asignaciones
        ]);
    }
}
