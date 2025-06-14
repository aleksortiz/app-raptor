<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VehiculosConcluidos extends Component
{
    public $keyWord;

    public $year;
    public $maxYear;
    public $weekStart;

    public $totalTerminados;
    public $totalEntregados;
    public $totalVehiculos;
    public $totalMateriales;
    public $totalCostos;
    public $totalUtilidad;

    public function getPorcentajeUtilidadProperty()
    {
        $porc = $this->totalCostos > 0 ? ($this->totalUtilidad / $this->totalCostos) * 100 : 0;
        return number_format($porc, 2);
    }

    protected $queryString = ['keyWord', 'year', 'weekStart'];

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function resetInput()
    {
    }

    public function render()
    {
        return view('livewire.entrada.vehiculos-concluidos.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $this->keyWord = trim($this->keyWord);
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekStart);
        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();

        // Query for vehicles completed in the selected week
        $completados = Entrada::OrderBy('id', 'desc')
            ->whereHas('avance', function ($avance) use ($start, $end) {
                $avance->whereBetween('terminado', [$start, $end]);
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
            ->with('avance');

        // Query for vehicles delivered in the selected week
        $entregados = Entrada::OrderBy('id', 'desc')
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
            });

        // Combine both queries
        $entradas = $completados->union($entregados);

        $entradasCollection = $entradas->get();
        
        // Calculate statistics
        $this->totalTerminados = $entradasCollection->filter(function ($entrada) {
            return $entrada->avance && $entrada->avance->terminado && !$entrada->fecha_entrega;
        })->count();

        $this->totalEntregados = $entradasCollection->filter(function ($entrada) {
            return $entrada->fecha_entrega;
        })->count();

        $this->totalVehiculos = $entradasCollection->count();

        // Calculate financial statistics
        $this->totalMateriales = $entradasCollection->sum('total_materiales');
        $this->totalCostos = $entradasCollection->sum('total');
        
        $entradasUtilidad = Entrada::whereHas('avance', function ($q) use ($start, $end) {
            $q->whereBetween('terminado', [$start, $end]);
        })
        ->get();


        $this->totalUtilidad = $entradasUtilidad->sum(function ($entrada) {
            return $entrada->total_utilidad_global ?? 0;
        });
        // $this->totalUtilidad = $entradasCollection->sum('total_utilidad_global');

        return [
            'entradas' => $entradas->paginate(50),
            'start' => $start,
            'end' => $end,
            'porcentajeUtilidad' => $this->getPorcentajeUtilidadProperty(),
        ];
    }
} 