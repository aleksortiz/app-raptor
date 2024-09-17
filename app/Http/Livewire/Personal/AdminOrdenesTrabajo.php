<?php

namespace App\Http\Livewire\Personal;

use App\Models\Costo;
use App\Models\Entrada;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrdenesTrabajo extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $personal_id;
    public $monto;
    public $porcentaje;
    public $notas;

    public $selected_costo;

    public $keyWord;
    public $year;
    public $maxYear;
    public $weekStart;
    public $weekEnd;
    public $origen;

    public $reportePersonal = false;

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd', 'reportePersonal'];

    public function mount(){
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render(){
        return view('livewire.personal.admin-ordenes-trabajo.view', $this->getRenderData());
    }

    public function updatedPorcentaje(){
      $this->porcentaje = trim($this->porcentaje) ? $this->porcentaje : 0;
      $this->monto = $this->selected_costo->presupuesto_mo * ($this->porcentaje / 100);
    }

    public function updatedMonto(){
      $this->monto = trim($this->monto) ? $this->monto : 0;
      $this->porcentaje = number_format($this->monto / $this->selected_costo->presupuesto_mo * 100);
    }

    public function getRenderDataPersonal(){
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $data = OrdenTrabajo::whereBetween('created_at', [$start, $end])
        ->withSum('pagos as total_pagado', 'monto')
        ->select('personal_id', DB::raw('SUM(monto) as total_monto'))
        ->groupBy('personal_id')->get();


        return [
            'data' => $data,
            'personal' => [],
        ];
    }

    public function getRenderData(){

        if($this->reportePersonal){
            return $this->getRenderDataPersonal();
        }

        $this->keyWord = trim($this->keyWord);
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $costos = Costo::where('tipo', 'MANO DE OBRA')
        ->whereHas('model', function($entrada) use($start, $end) {
            $entrada->whereBetween('created_at', [$start, $end]);
        })
        ->where(function ($q){
            $q->orWhereHas('model', function($entrada){
                $entrada->where('modelo', 'LIKE', "%{$this->keyWord}%")
                ->orWhere('folio', 'LIKE', "{$this->keyWord}%")
                ->orWhere('serie', 'LIKE', "{$this->keyWord}%")
                ->orWhere('orden', 'LIKE', "{$this->keyWord}%")
                ->orWhere(DB::raw('REPLACE(orden, " ", "")'), 'LIKE', trim($this->keyWord).'%')
                ->orWhereHas('fabricante', function($fab){
                    $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
                });
            });
        });

        if($this->origen){
            $costos->whereHas('model', function($entrada){
                $entrada->where('origen', $this->origen);
            });
        }

        $costos = $costos->orderBy('model_id', 'desc')->paginate(50);

        return [
            'data' => $costos,
            'personal' => Personal::where('activo', 1)->orderBy('nombre')->get(),
        ];
    }

    public function mdlCreate($costo_id){
        $this->selected_costo = Costo::findOrFail($costo_id);
        $this->emit('showModal', '#mdl');
    }

    public function createOrdenTrabajo(){

        $this->validate([
            'personal_id' => 'required|numeric',
            'monto' => 'required|numeric',
            'porcentaje' => 'required|numeric|min:10|max:100',
            'notas' => 'required|string',
        ]);

        OrdenTrabajo::create([
            'user_id' => auth()->id(),
            'entrada_id' => $this->selected_costo->model_id,
            'personal_id' => $this->personal_id,
            'monto' => $this->monto,
            'porcentaje' => $this->porcentaje,
            'notas' => $this->notas,
        ]);

        $this->selected_costo = null;
        $this->personal_id = null;
        $this->monto = null;
        $this->porcentaje = null;
        $this->notas = null;

        $this->emit('closeModal', '#mdl');
        $this->emit('ok', 'Orden de trabajo creada');
    }

    public function detalleDestajos($personal_id){
        // $this->personal_id = $personal_id;
        // $this->reportePersonal = true;
    }
}
