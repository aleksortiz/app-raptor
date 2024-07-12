<?php

namespace App\Http\Livewire\Material;

use App\Models\Entrada;
use App\Models\EntradaMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BitacoraMateriales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;
    public $totalMateriales;

    public $desglosar = false;

    public function updated(){
        $this->resetPage();
    }

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.material.bitacora-materiales.view', $this->getRenderData());
    }

    private function getRenderData(){
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        
        $materiales = EntradaMaterial::select(DB::raw('id, material_id, entrada_id, material, count(entrada_id) as c_entradas, precio, sum(cantidad) as cantidadSum, sum(precio * cantidad) as importeSum'))
        ->whereBetween('created_at', [$start, $end]);
    
        if($this->desglosar){
            $materiales->orderBy('created_at', 'desc');
            $materiales->groupBy('id');
        }else{
            $materiales->orderBy('importeSum', 'desc');
            $materiales->groupBy('material_id');
        }

        return [
            'materiales' => $materiales->paginate(50),
        ];
    }
}
