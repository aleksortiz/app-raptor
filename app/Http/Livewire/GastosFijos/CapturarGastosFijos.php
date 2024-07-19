<?php

namespace App\Http\Livewire\GastosFijos;

use App\Models\Entrada;
use App\Models\GastoFijo;
use App\Models\GastoFijoLog;
use Carbon\Carbon;
use Livewire\Component;

class CapturarGastosFijos extends Component
{

    public $week;
    public $year;
    public $maxYear;

    public $gastoDescripcion;
    public $gastoMonto;
    public $recurrente = false;

    public $bills = [];

    protected $rules = [
        'bills.*.monto' => 'required|numeric',
    ];

    protected $queryString = ['week', 'year'];

    public function getTotalGastosProperty()
    {
        $total = 0;
        foreach ($this->bills as $bill) {
            $total += $bill['monto'];
        }
        return $total;
    }

    public function mount()
    {
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->week = $this->week ? $this->week : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;        
    }

    public function render()
    {
        return view('livewire.gastos-fijos.capturar-gastos-fijos.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $start = Carbon::parse($dates[0]);
        $gastos = GastoFijo::all()->pluck('concepto');
        $logs = GastoFijoLog::where('fecha', $start->format('Y-m-d'))->get();

        $this->bills = [];

        foreach($logs as $log){
            if(!$gastos->contains($log->concepto)){
                $gastos->push($log->concepto);
            }
        }

        foreach ($gastos as $index => $gasto) {
            $this->bills[$index] = [
                'monto' => GastoFijo::getAmount($gasto, $this->year, $this->week),
                'concepto' => $gasto,
            ];
        }

        return [
            'gastos' => $gastos,
            'no_logs' => $logs->count() == 0,
        ];
    }

    public function copyLogs(){
        $start = Entrada::getDateRange($this->year, $this->week, $this->week);
        $start = Carbon::parse($start[0])->format('Y-m-d');

        foreach ($this->bills as $index => $bill) {
            $concepto = $bill['concepto'];
            $monto = GastoFijo::getLastAmount($concepto);
            GastoFijo::registerLog($start, $concepto, floatval($monto));
        }
    }
    
    public function saveGastos($notify = true){
        $this->validate([
            'bills.*.monto' => 'required|numeric|gte:0',
        ]);
        $start = Entrada::getDateRange($this->year, $this->week, $this->week);
        $start = Carbon::parse($start[0])->format('Y-m-d');
        foreach ($this->bills as $index => $bill) {
            $concepto = $bill['concepto'];
            $monto = $bill['monto'];
            GastoFijo::registerLog($start, $concepto, floatval($monto));
        }

        if($notify){
            $this->emit('ok', 'Gastos fijos guardados correctamente');
        }
    }

    public function mdlGasto(){
        $this->saveGastos(false);
        $this->emit('showModal', '#mdlGasto');
    }

    public function guardarGasto(){
        $this->validate([
            'gastoDescripcion' => 'required',
            'gastoMonto' => 'required|numeric',
        ]);
        $concepto = strtoupper($this->gastoDescripcion);
        $start = Entrada::getDateRange($this->year, $this->week, $this->week);
        $start = Carbon::parse($start[0]);

        if($this->gastoMonto){
            GastoFijo::registerLog($start, $concepto, floatval($this->gastoMonto));
        }
        else{
            GastoFijo::where('created_at', '=', $start)
            ->where('concepto', '=', $concepto)->delete();
        }
        
        if($this->recurrente){
            GastoFijo::create([
                'concepto' => $concepto,
            ]);
        }

        $this->gastoDescripcion = '';
        $this->gastoMonto = '';
        $this->recurrente = false;
        $this->emit('closeModal', '#mdlGasto');
    }


}
