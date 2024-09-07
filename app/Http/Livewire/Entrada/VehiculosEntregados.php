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

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd'];

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
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
        ->whereBetween('fecha_entrega', [$start, $end])
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
        ->where('fecha_entrega', '!=', null);

        $this->totalRefacciones = collect($entradas->get())->sum('total_refacciones');
        $this->totalMateriales = collect($entradas->get())->sum('total_materiales');
        $this->totalCostos = collect($entradas->get())->sum('total');
        $this->totalUtilidad = collect($entradas->get())->sum('total_utilidad_global');

        return [
            'entradas' => $entradas->paginate(50),
        ];
    }
}
