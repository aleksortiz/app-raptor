<?php

namespace App\Http\Livewire\Business;

use App\Models\Entrada;
use App\Models\EntradaMaterial;
use App\Models\GastoFijoLog;
use App\Models\OrdenTrabajoPago;
use App\Models\PagoPersonal;
use App\Models\Pedido;
use Carbon\Carbon;
use Livewire\Component;

class FinanceDashboard extends Component
{

    public $week;
    public $year;
    public $maxYear;

    protected $queryString = ['week', 'year'];

    public $activeSection = null;

    public function mount(){
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->week = $this->week ? $this->week : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function getCantVehiculosRegistradosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        return Entrada::whereBetween('created_at', $dates)->count();
    }

    public function getTotalVehiculosRegistradosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $entradas = Entrada::whereBetween('created_at', $dates)->get();
        return collect($entradas)->sum('total');
    }

    public function getCantVehiculosEntregadosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        return Entrada::whereBetween('fecha_entrega', $dates)->count();
    }

    public function getTotalMaterialesProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $entradas = EntradaMaterial::whereBetween('created_at', $dates)->get();
        return collect($entradas)->sum('importe');
    }

    public function getTotalSueldosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $pagos = PagoPersonal::whereBetween('fecha', $dates)->sum('pago');
        $destajos = OrdenTrabajoPago::whereBetween('created_at', $dates)->sum('monto');
        return $pagos + $destajos;
    }

    public function getTotalGastosFijosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $gastos = GastoFijoLog::whereBetween('fecha', $dates)->sum('monto');
        return $gastos;
    }

    public function getTotalPagosRealizadosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $entradas = Entrada::whereBetween('created_at', $dates)->get();
        $totalPagado = 0;
        foreach($entradas as $entrada){
            $totalPagado += $entrada->total_costos_pagados;
        }
        return $totalPagado;

    }

    public function getTotalPagosPendientesProperty(){
        // return $this->total_vehiculos_registrados - $this->total_pagos_realizados;
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $entradas = Entrada::whereBetween('created_at', $dates)->get();
        $totalPendiente = 0;
        foreach($entradas as $entrada){
            $totalPendiente += $entrada->total_costos_pendientes;
        }
        return $totalPendiente;
    }

    public function getTotalUtilidadRealProperty(){
        return $this->total_pagos_realizados 
        - $this->total_sueldos 
        - $this->total_gastos_fijos 
        - $this->total_pedidos;
    }

    public function getTotalUtilidadVirtualProperty(){
        return $this->total_vehiculos_registrados
        - $this->total_sueldos 
        - $this->total_gastos_fijos 
        - $this->total_pedidos;
    }

    public function getTotalPedidosProperty(){
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        $pedidos = Pedido::whereBetween('created_at', $dates)
        ->where('canceled_at', null)->get();
        return collect($pedidos)->sum('total');
    }

    public function render()
    {
        return view('livewire.business.finance-dashboard.view');
    }
}
