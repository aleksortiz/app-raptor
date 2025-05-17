<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use Carbon\Carbon;
use Livewire\Component;

class VehiculosEntregados extends Component
{
    public $keyWord;

    public $year;
    public $maxYear;
    public $weekStart;
    public $weekEnd;

    public $totalRefacciones;
    public $totalMateriales;
    public $totalCostos;
    public $totalUtilidad;

    public function getPorcentajeUtilidadProperty()
    {
        $porc = $this->totalCostos > 0 ? ($this->totalUtilidad / $this->totalCostos) * 100 : 0;
        return number_format($porc, 2);
    }

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd'];

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function resetInput()
    {
    }

    public function render()
    {
        return view('livewire.entrada.vehiculos-entregados.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $this->keyWord = trim($this->keyWord);
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $entradas = Entrada::OrderBy('id', 'desc')
        ->where(function ($q) use ($start, $end) {
            $q->where(function ($subQ) use ($start, $end) {
                $subQ->whereHas('avance', function ($avance) use ($start, $end) {
                    $avance->whereBetween('terminado', [$start, $end]);
                });
            })->orWhere(function ($subQ) use ($start, $end) {
                $subQ->whereDoesntHave('avance')
                    ->whereBetween('fecha_entrega', [$start, $end]);
            });
        })
        ->where(function ($q) {
            $q->orWhere('modelo', 'LIKE', "%{$this->keyWord}%")
                ->orWhereHas('fabricante', function ($fab) {
                    $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
                })
                ->orWhereHas('cliente', function ($fab) {
                    $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
                })
                ->orWhere('folio', 'LIKE', "{$this->keyWord}%")
                ->orWhere('id', $this->keyWord);
        })
        ->where(function ($q) {
            $q->whereHas('avance', function ($avance) {
                $avance->whereNotNull('terminado');
            })->orWhereNotNull('fecha_entrega');
        });

        $this->totalRefacciones = collect($entradas->get())->sum('total_refacciones');
        $this->totalMateriales = collect($entradas->get())->sum('total_materiales');
        $this->totalCostos = collect($entradas->get())->sum('total');
        $this->totalUtilidad = collect($entradas->get())->sum('total_utilidad_global');

        return [
            'entradas' => $entradas->paginate(50),
        ];
    }
}
