<?php

namespace App\Http\Livewire\Business;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Models\Ingreso;
use Carbon\Carbon;

class CapturarIngresos extends LivewireBaseCrudController
{
    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    public $model;
    public $modelName = "Depósito";

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
        return view('livewire.business.capturar-ingresos.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $ingresos = Ingreso::whereBetween('fecha', $dates);
        $total = Ingreso::whereBetween('fecha', $dates)->get()->sum('monto');

        return [
            'ingresos' => $ingresos->paginate(50),
            'total' => $total,
        ];
    }

    public function mdlCreate(){
        $this->model = new Ingreso();
        $this->model->fecha = Carbon::now()->toDateTimeString();
        $this->emit('showModal', '#mdl');
    }

    public function save(){
        $this->validate();

        $this->model->user_id = auth()->id();

        $this->model->save();
        $this->model = new Ingreso();
        $this->emit('closeModal', '#mdl');
        $this->emit('ok', "Se ha resgistrado {$this->modelName}");
    }

    public function remove($id){
        Ingreso::findOrFail($id)->delete();
        $this->emit('ok', "Se ha eliminado {$this->modelName}");
    }


}
