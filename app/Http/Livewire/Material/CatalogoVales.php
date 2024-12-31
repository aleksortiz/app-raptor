<?php

namespace App\Http\Livewire\Material;

use App\Models\Entrada;
use App\Models\EntradaMaterial;
use App\Models\ValeMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoVales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    protected $queryString = ['year', 'weekStart', 'weekEnd'];

    public function updated(){
        $this->resetPage();
    }

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.material.catalogo-vales.view', $this->getRenderData());
    }

    private function getRenderData(){
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $vales = ValeMaterial::orderBy('id', 'desc')
        ->whereBetween('created_at', [$start, $end]);

        return [
            'vales' => $vales->paginate(50),
        ];
    }
}
