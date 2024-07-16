<?php

namespace App\Http\Livewire\Business;

use App\Models\Costo;
use App\Models\Entrada;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteFacturas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyWord;

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    protected $queryString = ['weekStart', 'weekEnd', 'year', 'keyWord'];

    public function mount(){
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->weekStart = $this->weekStart ? $this->weekStart : $today->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.business.reporte-facturas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $costos = Costo::orderBy('pagado', 'asc');

        if($this->keyWord){
            $costos->whereHas('model', function($query){
                $query->where('orden', 'like', '%'.$this->keyWord.'%');
            });
        }else{
            $costos->whereBetween('pagado', $dates);
            $costos->orWhere('pagado', null);
        }

        $pagado = Costo::whereBetween('pagado', $dates)->get()->sum('costo');
        $pendiente = Costo::where('pagado', null)->get()->sum('costo');

        return [
            'servicios' => $costos->paginate(50),
            'pagado' => $pagado,
            'pendiente' => $pendiente,
        ];
    }
}
