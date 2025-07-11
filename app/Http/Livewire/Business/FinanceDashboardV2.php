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
    public $week;
    public $year;
    public $maxYear;

    protected $queryString = ['week', 'year'];

    public function mount()
    {
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->week = $this->week ? $this->week : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    protected function getDateRange()
    {
        $dates = Entrada::getDateRange($this->year, $this->week, $this->week);
        return $dates;
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
        $dates = $this->getDateRange();
        $entradas = Entrada::whereBetween('created_at', $dates)->get();
        
        return (object)[
            'count' => $entradas->count(),
            'total' => collect($entradas)->sum('total')
        ];
    }

    public function getVehiculosTerminadosProperty()
    {
        $dates = $this->getDateRange();
        $start = Carbon::parse($dates[0])->startOfDay();
        $end = Carbon::parse($dates[1])->endOfDay();
        
        $entradas = Entrada::whereHas('avance', function($q) use ($start, $end) {
            $q->whereBetween('terminado', [$start, $end]);
        })
        // Exclude vehicles that were also delivered in the same week
        ->where(function($query) use ($start, $end) {
            $query->whereNull('fecha_entrega')
                  ->orWhere(function($q) use ($start, $end) {
                      $q->whereNotBetween('fecha_entrega', [$start, $end]);
                  });
        })
        ->get();

        return (object)[
            'count' => $entradas->count(),
            'total' => collect($entradas)->sum('total'),
            'total_utilidad_global' => collect($entradas)->sum('total_utilidad_global')
        ];
    }

    public function getVehiculosEntregadosProperty()
    {
        $dates = $this->getDateRange();
        $start = Carbon::parse($dates[0])->startOfDay();
        $end = Carbon::parse($dates[1])->endOfDay();
        
        // Only count vehicles that were both completed and delivered in the same week
        $entradas = Entrada::whereBetween('fecha_entrega', [$start, $end])
            ->whereNotNull('fecha_entrega')
            ->whereHas('avance', function($q) use ($start, $end) {
                $q->whereBetween('terminado', [$start, $end]);
            })
            ->get();

        return (object)[
            'count' => $entradas->count(),
            'total' => collect($entradas)->sum('total'),
            'total_utilidad_global' => collect($entradas)->sum('total_utilidad_global')
        ];
    }

    public function getTotalMaterialesProperty()
    {
        $dates = $this->getDateRange();
        $entradas = EntradaMaterial::whereBetween('created_at', $dates)->get();
        return collect($entradas)->sum('importe');
    }

    public function getTotalNominaProperty()
    {
        $dates = $this->getDateRange();
        return PagoPersonal::whereBetween('fecha', $dates)
            ->whereNotNull('entrada_id')
            ->whereHas('personal', function($q) {
                $q->where('destajo', false)
                ->where('administrativo', false);
            })
            ->sum('pago') ?? 0;
    }

    public function getTotalNominaAdministrativaProperty()
    {
        $dates = $this->getDateRange();
        return PagoPersonal::whereBetween('fecha', $dates)
            ->whereHas('personal', function($q) {
                $q->where('administrativo', true);
            })
            ->sum('pago') ?? 0;
    }

    public function getTotalDestajosProperty()
    {
        $dates = $this->getDateRange();
        return OrdenTrabajo::whereBetween('created_at', $dates)
            ->sum('monto') ?? 0;
    }

    public function getTotalSueldosProperty()
    {
        return $this->total_nomina + $this->total_destajos;
    }

    public function getTotalGastosFijosProperty()
    {
        $dates = $this->getDateRange();
        return GastoFijoLog::whereBetween('fecha', $dates)
            ->sum('monto') ?? 0;
    }

    public function getTotalPagosRealizadosProperty()
    {
        $dates = $this->getDateRange();
        $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
        $totalPagado = 0;
        foreach($entradas as $entrada){
            $totalPagado += $entrada->total_costos_pagados;
        }
        return $totalPagado;
    }

    public function getTotalPedidosProperty()
    {
        $dates = $this->getDateRange();
        $pedidos = Pedido::whereBetween('created_at', $dates)
            ->whereNull('canceled_at')
            ->with('conceptos')
            ->get();
            
        return $pedidos->sum(function($pedido) {
            return $pedido->conceptos->sum(function($concepto) {
                return $concepto->cantidad * $concepto->precio;
            });
        });
    }

    public function getTotalPagosProveedoresProperty()
    {
        $dates = $this->getDateRange();
        $pedidos = Pedido::whereBetween('pagado', $dates)
            ->whereNull('canceled_at')
            ->with('conceptos')
            ->get();
            
        return $pedidos->sum(function($pedido) {
            return $pedido->conceptos->sum(function($concepto) {
                return $concepto->cantidad * $concepto->precio;
            });
        });
    }

    public function getTotalPendienteProveedoresProperty()
    {
        return $this->total_pedidos - $this->total_pagos_proveedores;
    }

    public function getTotalGastosGeneralesProperty()
    {
        $dates = $this->getDateRange();
        $gastos = Egreso::whereBetween('created_at', $dates)->sum('monto');
        return $gastos;
    }

    public function getTotalGastosProperty()
    {
        return $this->total_nomina_administrativa
            + $this->total_nomina_taller
            + $this->total_gastos_fijos
            + $this->total_gastos_generales;
    }

    public function getUtilidadBrutaProperty()
    {
        return $this->vehiculos_entregados->total_utilidad_global
            + $this->vehiculos_terminados->total_utilidad_global;
    }

    public function getUtilidadNetaProperty()
    {
        return $this->utilidad_bruta - $this->total_gastos;
    }

    public function getPorcUtilidadNetaProperty()
    {
        if ($this->utilidad_bruta <= 0) {
            return 0;
        }

        try {
            return ($this->utilidad_neta / $this->utilidad_bruta) * 100;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getTotalNominaTallerProperty()
    {
        $dates = $this->getDateRange();
        return PagoPersonal::whereBetween('fecha', $dates)
            ->whereNull('entrada_id')
            ->whereHas('personal', function($q) {
                $q->where('destajo', false)
                ->where('administrativo', false);
            })
            ->sum('pago') ?? 0;
    }

    public function getQtySemanasProperty()
    {
        return $this->weekEnd - $this->weekStart + 1;
    }

    public function render()
    {
        return view('livewire.business.finance-dashboard-v2.view');
    }
} 