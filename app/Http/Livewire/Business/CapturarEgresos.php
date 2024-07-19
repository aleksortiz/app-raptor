<?php

namespace App\Http\Livewire\Business;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Egreso;
use App\Models\Entrada;
use Carbon\Carbon;

class CapturarEgresos extends LivewireBaseCrudController
{
    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    public $model;
    public $modelName = "Gasto";

    protected $listeners = ['remove'];
    protected $queryString = ['weekStart', 'weekEnd', 'year'];

    protected $rules = [
        'model.monto' => 'required|numeric|min:0',
        'model.concepto' => 'required|string|max:255',
        'model.fecha' => 'required|date',
    ];

    public function mount(){
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.business.capturar-egresos.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $egresos = Egreso::whereBetween('fecha', $dates);
        $total = Egreso::whereBetween('fecha', $dates)->get()->sum('monto');

        return [
            'egresos' => $egresos->paginate(50),
            'total' => $total,
        ];
    }

    public function mdlCreate(){
        $this->model = new Egreso();
        $this->model->fecha = Carbon::now()->toDateTimeString();
        $this->emit('showModal', '#mdl');
    }

    public function save(){
        $this->validate();

        $this->model->user_id = auth()->id();

        $this->model->save();
        $this->model = new Egreso();
        $this->emit('closeModal', '#mdl');
        $this->emit('ok', "Se ha resgistrado {$this->modelName}");
    }

    public function remove($id){
        Egreso::findOrFail($id)->delete();
        $this->emit('ok', "Se ha eliminado {$this->modelName}");
    }
}
