<?php

namespace App\Http\Livewire\Refaccion;

use App\Models\Refaccion;
use Carbon\Carbon;
use Livewire\Component;

class ReporteComisiones extends Component
{
    public $weekStart;
    public $weekEnd;
    public $maxYear;
    public $year;

    protected $query = ['weekStart', 'weekEnd', 'year'];

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.refaccion.reporte-comisiones.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        return [
            'data' => Refaccion::paginate(50),
        ];
    }
}
