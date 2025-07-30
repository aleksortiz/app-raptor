<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Entrada;
use App\Models\Valuacion;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoValuaciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['reloadCitasValuacion' => '$refresh'];

    public $start;
    public $end;
    public $year;
    public $maxYear;
    public $search = '';

    protected $queryString = ['year', 'start', 'end', 'search'];

    public function updated(){
        $this->resetPage();
    }

    public function mount()
    {
        $this->start = $this->start ? $this->start : Carbon::today()->weekOfYear;
        $this->end = $this->end ? $this->end : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.valuacion.catalogo-valuaciones.view', $this->getRenderData());
    }

    public function getRenderData(){
      $valuaciones = Valuacion::orderBy('id', 'desc');
      
      if (!empty($this->search)) {
          // Apply search filters
          $valuaciones->where(function($query) {
              $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('numero_reporte', 'like', '%' . $this->search . '%')
                  ->orWhere('modelo', 'like', '%' . $this->search . '%')
                  ->orWhere('marca', 'like', '%' . $this->search . '%');
          });
      } else {
          // Apply date range filters only if not searching
          $dates = Entrada::getDateRange($this->year, $this->start, $this->end);
          $valuaciones->whereBetween('created_at', $dates);
      }

      return [
        'valuaciones' => $valuaciones->paginate(50),
      ];
    }

}
