<?php

namespace App\Http\Livewire\Business;

use App\Models\Costo;
use App\Models\Egreso;
use App\Models\Entrada;
use App\Models\EntradaMaterial;
use App\Models\GastoFijoLog;
use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoPago;
use App\Models\PagoPersonal;
use App\Models\Pedido;
use Carbon\Carbon;
use Livewire\Component;

class FinanceDashboard extends Component
{

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    public $viewGraph = false;

    protected $queryString = ['weekStart','weekEnd', 'year', 'viewGraph'];

    public $activeSection = null;

    public function mount(){
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->weekStart = $this->weekStart ? $this->weekStart : $today->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function getCantVehiculosRegistradosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        return Entrada::whereBetween('created_at', $dates)->count();
    }

    public function getTotalVehiculosRegistradosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = Entrada::whereBetween('created_at', $dates)->get();
        return collect($entradas)->sum('total');
    }

    public function getCantVehiculosEntregadosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        return Entrada::whereBetween('fecha_entrega', $dates)->count();
    }

    public function getTotalVehiculosEntregadosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        return collect($entradas)->sum('total');
    }

    public function getTotalMaterialesProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = EntradaMaterial::whereBetween('created_at', $dates)->get();
        return collect($entradas)->sum('importe');
    }

    public function getTotalNominaProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $pagos = PagoPersonal::whereBetween('fecha', $dates)->whereHas('personal',function($personal){
            $personal->where('destajo', false);
        })->sum('pago');
        return $pagos;
    }

    public function getTotalNominaAdministrativaProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $pagos = PagoPersonal::whereBetween('fecha', $dates)->whereHas('personal', function($q){
            $q->where('administrativo', true);
        })->sum('pago');
        return $pagos;
    }

    public function getTotalDestajosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        // $destajos = OrdenTrabajoPago::whereBetween('created_at', $dates)->sum('monto');
        $destajos = OrdenTrabajo::whereBetween('created_at', $dates)->sum('monto');
        return $destajos;
    }


    public function getTotalSueldosProperty(){
        return $this->total_nomina + $this->total_destajos;
    }

    public function getTotalGastosFijosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $gastos = GastoFijoLog::whereBetween('fecha', $dates)->sum('monto');
        return $gastos;
    }

    public function getTotalPagadoProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        $totalPagado = 0;
        foreach($entradas as $entrada){
            $totalPagado += $entrada->total_costos_pagados;
        }
        return $totalPagado;
    }

    public function getTotalPagosRealizadosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        // $entradas = Entrada::whereBetween('created_at', $dates)->get();
        // $totalPagado = 0;
        // foreach($entradas as $entrada){
        //     $totalPagado += $entrada->total_costos_pagados;
        // }
        // return $totalPagado;
        return Costo::whereBetween('pagado', $dates)->sum('costo');
    }

    public function getTotalPagosPendientesProperty(){
        // return $this->total_vehiculos_registrados - $this->total_pagos_realizados;
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        $totalPendiente = 0;
        foreach($entradas as $entrada){
            $totalPendiente += $entrada->total_costos_pendientes;
        }
        return $totalPendiente;
    }

    public function getTotalUtilidadRealProperty(){
        return $this->total_pagos_realizados
        - $this->total_gastos;
    }

    public function getTotalUtilidadVirtualProperty(){
        return $this->total_vehiculos_registrados
        - $this->total_sueldos
        - $this->total_gastos_fijos
        - $this->total_pedidos;
    }

    public function getTotalPedidosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $pedidos = Pedido::whereBetween('created_at', $dates)
        ->where('canceled_at', null)->get();
        return collect($pedidos)->sum('total');
    }

    public function getTotalPagosProveedoresProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $pedidos = Pedido::whereBetween('pagado', $dates)
        ->where('canceled_at', null)->get();
        return collect($pedidos)->sum('total');
    }

    public function getTotalGastosProperty(){
        // return $this->total_sueldos + $this->total_gastos_fijos + $this->totalPagosProveedores;
        return $this->total_sueldos_taller
        + $this->total_gastos_fijos
        + $this->total_gastos_generales
        + $this->totalPagosProveedores;
    }

    public function getUtilidadBrutaProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        return collect($entradas)->sum('total_utilidad_global');
    }

    public function getUtilidadNetaProperty(){
        return $this->utilidad_bruta - $this->total_sueldos_taller - $this->total_gastos_fijos - $this->total_gastos_generales;
    }

    public function getTotalGastosGeneralesProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $gastos = Egreso::whereBetween('created_at', $dates)->sum('monto');
        return $gastos;
    }

    public function getTotalSueldosTallerProperty(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $pagos = PagoPersonal::whereBetween('fecha', $dates)->where('entrada_id', null)->sum('pago');
        return $pagos;
    }

    public function getPorcUtilidadNetaProperty(){
        if($this->total_vehiculos_entregados <= 0){
            return 0;
        }

        try{
            return ($this->utilidad_neta / $this->total_vehiculos_entregados) * 100;
        }
        catch(\Exception $e){
            return 0;
        }
    }

    public function render()
    {
        if($this->viewGraph){
            $this->clickGraph();
        }
        return view('livewire.business.finance-dashboard.view');
    }

    public function clickGraph(){
        $weeks = [];
        $utilidad_neta = [];
        $utilidad_bruta = [];
        for($i = $this->weekStart; $i <= $this->weekEnd; $i++){
            $weeks[] = "Semana $i";
            $utilidad_bruta[] = round($this->utilidadBrutaByWeek($i), 2);
            $utilidad_neta[] = round($this->utilidadNetaByWeek($i), 2);
        }
        $this->emit('loadGraphLive', $weeks, $utilidad_neta, $utilidad_bruta);
    }

    public function utilidadBrutaByWeek($week){
        $dates = Entrada::getDateRange($this->year, $week, $week);
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        return collect($entradas)->sum('total_utilidad_global');
    }

    public function sueldosTallerByWeek($week){
        $dates = Entrada::getDateRange($this->year, $week, $week);
        $pagos = PagoPersonal::whereBetween('fecha', $dates)->where('entrada_id', null)->sum('pago');
        return $pagos;
    }

    public function gastosFijosByWeek($week){
        $dates = Entrada::getDateRange($this->year, $week, $week);
        $gastos = GastoFijoLog::whereBetween('fecha', $dates)->sum('monto');
        return $gastos;
    }

    public function gastosGeneralesByWeek($week){
        $dates = Entrada::getDateRange($this->year, $week, $week);
        $gastos = Egreso::whereBetween('created_at', $dates)->sum('monto');
        return $gastos;
    }

    public function utilidadNetaByWeek($week){
        $utilidadBruta = $this->utilidadBrutaByWeek($week);
        $sueldosTaller = $this->sueldosTallerByWeek($week);
        $gastosFijos = $this->gastosFijosByWeek($week);
        $gastosGenerales = $this->gastosGeneralesByWeek($week);
        return $utilidadBruta - $sueldosTaller - $gastosFijos - $gastosGenerales;
    }

    public function getQtySemanasProperty(){
        return $this->weekEnd - $this->weekStart + 1;
    }

}
