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
use Illuminate\Support\Facades\DB;

class FinanceDashboardV2 extends Component
{
    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;
    public $viewGraph = false;

    protected $queryString = ['weekStart', 'weekEnd', 'year', 'viewGraph'];

    public function mount()
    {
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->weekStart = $this->weekStart ? $this->weekStart : $today->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    protected function getDateRange()
    {
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        return [
            Carbon::parse($dates[0])->startOfDay(),
            Carbon::parse($dates[1])->endOfDay()
        ];
    }

    protected function getDefaultVehicleStats()
    {
        return (object)[
            'count' => 0,
            'total' => 0
        ];
    }

    protected function calculateTotalForEntradas($entradas)
    {
        return $entradas->sum(function($entrada) {
            return $entrada->total;
        });
    }

    public function getVehiculosRegistradosProperty()
    {
        [$start, $end] = $this->getDateRange();
        $entradas = Entrada::whereBetween('created_at', [$start, $end])->get();
        
        return (object)[
            'count' => $entradas->count(),
            'total' => $this->calculateTotalForEntradas($entradas)
        ];
    }

    public function getVehiculosTerminadosProperty()
    {
        [$start, $end] = $this->getDateRange();
        $entradas = Entrada::whereHas('avance', function($q) use ($start, $end) {
            $q->whereBetween('terminado', [$start, $end]);
        })
        ->whereNull('fecha_entrega')
        ->get();

        return (object)[
            'count' => $entradas->count(),
            'total' => $this->calculateTotalForEntradas($entradas)
        ];
    }

    public function getVehiculosEntregadosProperty()
    {
        [$start, $end] = $this->getDateRange();
        $entradas = Entrada::whereBetween('fecha_entrega', [$start, $end])->get();

        return (object)[
            'count' => $entradas->count(),
            'total' => $this->calculateTotalForEntradas($entradas)
        ];
    }

    public function getTotalMaterialesProperty()
    {
        [$start, $end] = $this->getDateRange();
        return EntradaMaterial::whereBetween('created_at', [$start, $end])
            ->sum('importe') ?? 0;
    }

    public function getTotalNominaProperty()
    {
        [$start, $end] = $this->getDateRange();
        return PagoPersonal::whereBetween('fecha', [$start, $end])
            ->whereHas('personal', function($q) {
                $q->where('destajo', false)
                ->where('administrativo', false);
            })
            ->sum('pago') ?? 0;
    }

    public function getTotalNominaAdministrativaProperty()
    {
        [$start, $end] = $this->getDateRange();
        return PagoPersonal::whereBetween('fecha', [$start, $end])
            ->whereHas('personal', function($q) {
                $q->where('administrativo', true);
            })
            ->sum('pago') ?? 0;
    }

    public function getTotalDestajosProperty()
    {
        [$start, $end] = $this->getDateRange();
        return OrdenTrabajo::whereBetween('created_at', [$start, $end])
            ->sum('monto') ?? 0;
    }

    public function getTotalSueldosProperty()
    {
        return $this->total_nomina + $this->total_destajos;
    }

    public function getTotalGastosFijosProperty()
    {
        [$start, $end] = $this->getDateRange();
        return GastoFijoLog::whereBetween('fecha', [$start, $end])
            ->sum('monto') ?? 0;
    }

    public function getTotalPagosRealizadosProperty()
    {
        [$start, $end] = $this->getDateRange();
        return Costo::whereBetween('pagado', [$start, $end])
            ->sum('costo') ?? 0;
    }

    public function getTotalPedidosProperty()
    {
        [$start, $end] = $this->getDateRange();
        return Pedido::whereBetween('created_at', [$start, $end])
            ->whereNull('canceled_at')
            ->sum('total') ?? 0;
    }

    public function getTotalPagosProveedoresProperty()
    {
        [$start, $end] = $this->getDateRange();
        return Pedido::whereBetween('pagado', [$start, $end])
            ->whereNull('canceled_at')
            ->sum('total') ?? 0;
    }

    public function getTotalPendienteProveedoresProperty()
    {
        return $this->total_pedidos - $this->total_pagos_proveedores;
    }

    public function getTotalGastosGeneralesProperty()
    {
        [$start, $end] = $this->getDateRange();
        return Egreso::whereBetween('created_at', [$start, $end])
            ->sum('monto') ?? 0;
    }

    public function getTotalGastosProperty()
    {
        return $this->total_nomina_administrativa
            + $this->total_gastos_fijos
            + $this->total_gastos_generales;
    }

    public function getUtilidadBrutaProperty()
    {
        [$start, $end] = $this->getDateRange();
        $entradas = Entrada::whereBetween('fecha_entrega', [$start, $end])->get();
        return $entradas->sum('total_utilidad_global') ?? 0;
    }

    public function getUtilidadNetaProperty()
    {
        return $this->utilidad_bruta - $this->total_gastos;
    }

    public function getPorcUtilidadNetaProperty()
    {
        $total = $this->vehiculos_entregados->total ?? 0;
        if ($total <= 0) {
            return 0;
        }

        try {
            return ($this->utilidad_neta / $total) * 100;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getQtySemanasProperty()
    {
        return $this->weekEnd - $this->weekStart + 1;
    }

    public function render()
    {
        if ($this->viewGraph) {
            $this->loadGraph();
        }
        
        return view('livewire.business.finance-dashboard-v2.view');
    }

    protected function loadGraph()
    {
        $weeks = [];
        $utilidad_neta = [];
        $utilidad_bruta = [];
        
        for ($i = $this->weekStart; $i <= $this->weekEnd; $i++) {
            $weeks[] = "Semana $i";
            $dates = Entrada::getDateRange($this->year, $i, $i);
            $start = Carbon::parse($dates[0])->startOfDay();
            $end = Carbon::parse($dates[1])->endOfDay();

            // Get utilidad bruta
            $entradas = Entrada::whereBetween('fecha_entrega', [$start, $end])->get();
            $bruta = $entradas->sum('total_utilidad_global') ?? 0;
            $utilidad_bruta[] = round($bruta, 2);

            // Calculate neta by subtracting gastos
            $gastos = (GastoFijoLog::whereBetween('fecha', [$start, $end])->sum('monto') ?? 0)
                + (Egreso::whereBetween('created_at', [$start, $end])->sum('monto') ?? 0)
                + (PagoPersonal::whereBetween('fecha', [$start, $end])
                    ->whereHas('personal', function($q) {
                        $q->where('administrativo', true);
                    })->sum('pago') ?? 0);

            $utilidad_neta[] = round($bruta - $gastos, 2);
        }

        $this->emit('loadGraphLive', $weeks, $utilidad_neta, $utilidad_bruta);
    }
} 