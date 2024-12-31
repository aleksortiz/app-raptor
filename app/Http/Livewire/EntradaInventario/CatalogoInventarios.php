<?php

namespace App\Http\Livewire\EntradaInventario;

use App\Models\Entrada;
use App\Models\EntradaInventario;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoInventarios extends Component
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
        return view('livewire.entrada-inventario.catalogo-inventarios.view', $this->getRenderData());
    }

    private function getRenderData(){
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $inventarios = EntradaInventario::orderBy('id', 'desc')
        ->whereBetween('created_at', [$start, $end]);

        return [
            'inventarios' => $inventarios->paginate(50),
        ];
    }
}
