<?php

namespace App\Http\Livewire\Entrada;

use App\Http\Traits\StatusButtonsTrait;
use App\Models\Entrada;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoEntradas extends Component
{
    use StatusButtonsTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyWord;
    public $model_name = "Entrada";
    public $model_name_plural = "Entradas";

    public $year;
    public $maxYear;
    public $weekStart;
    public $weekEnd;
    public $origen;

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd'];

    protected $listeners = [
        'pagarRefacciones',
        'pagarEntrada',
        'entregarVehiculo',
    ];

    public function mount(){
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function resetInput(){
    }

    public function render()
    {
        return view('livewire.entrada.catalogo-entradas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $this->keyWord = trim($this->keyWord);
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $entradas = Entrada::OrderBy('id','desc')
        ->whereBetween('created_at', [$start, $end])
        ->where(function ($q){
            $q->orWhere('modelo', 'LIKE', "%{$this->keyWord}%")
            ->orWhereHas('fabricante', function($fab){
                $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
            })
            ->orWhereHas('cliente', function($fab){
                $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
            })
            ->orWhere('folio', 'LIKE', "{$this->keyWord}%");
        });

        if($this->origen){
            $entradas = $entradas->where('origen', $this->origen);
        }

        $entradas = $entradas->paginate(50);

        return [
            'entradas' => $entradas,
        ];
    }
}
