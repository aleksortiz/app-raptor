<?php

namespace App\Http\Livewire\Personal;

use App\Models\OrdenTrabajo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoDestajos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $weekStart;
    public $year;
    public $maxYear;
    public $totalPendiente;
    public $totalPagado;
    public $ordenesDetalle = [];
    public $showModal = false;
    public $isCurrentWeek = false;

    protected $queryString = ['year', 'weekStart'];

    public function updated()
    {
        $this->resetPage();
        // Add a small delay to make loading state visible
        usleep(500000); // 500ms delay
        $this->checkIfCurrentWeek();
    }

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
        $this->checkIfCurrentWeek();
    }

    private function checkIfCurrentWeek()
    {
        $currentWeek = Carbon::today()->weekOfYear;
        $currentYear = Carbon::today()->year;
        $this->isCurrentWeek = ($this->weekStart == $currentWeek && $this->year == $currentYear);
    }

    public function verOrdenes($personalId)
    {
        [$start, $end] = $this->getDateRange();

        $this->ordenesDetalle = OrdenTrabajo::with(['entrada', 'personal'])
            ->where('personal_id', $personalId)
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->map(function ($orden) {
                return [
                    'id' => $orden->id,
                    'folio_short' => $orden->entrada->folio_short,
                    'entrada_id' => $orden->entrada_id,
                    'vehiculo' => $orden->entrada->vehiculo,
                    'notas' => $orden->notas,
                    'monto' => $orden->monto,
                    'pagado' => $orden->pagado,
                    'pendiente' => $orden->pendiente,
                ];
            });

        $this->emit('showModal');
    }

    public function render()
    {
        return view('livewire.personal.catalogo-destajos.view', $this->getRenderData());
    }

    private function getRenderData()
    {
        [$start, $end] = $this->getDateRange();

        $pagosSubquery = DB::table('orden_trabajo_pagos')
            ->select(
                'orden_trabajo_id',
                DB::raw('SUM(monto) as total_pagado')
            )
            ->groupBy('orden_trabajo_id');
    
        $destajos = DB::table('ordenes_trabajo')
            ->join('personal', 'ordenes_trabajo.personal_id', '=', 'personal.id')
            ->leftJoinSub($pagosSubquery, 'pagos', function ($join) {
                $join->on('pagos.orden_trabajo_id', '=', 'ordenes_trabajo.id');
            })
            ->select(
                'ordenes_trabajo.personal_id',
                'personal.nombre',
                DB::raw('COUNT(*) as total_ordenes'),
                DB::raw('SUM(ordenes_trabajo.monto) as monto_total'),
                DB::raw('COALESCE(SUM(pagos.total_pagado), 0) as monto_pagado'),
                DB::raw('SUM(ordenes_trabajo.monto) - COALESCE(SUM(pagos.total_pagado), 0) as monto_pendiente')
            )
            ->whereBetween('ordenes_trabajo.created_at', [$start, $end])
            ->groupBy('ordenes_trabajo.personal_id', 'personal.nombre')
            ->orderBy('monto_total', 'desc');

        $this->totalPendiente = DB::table('ordenes_trabajo')
            ->leftJoin('orden_trabajo_pagos', 'ordenes_trabajo.id', '=', 'orden_trabajo_pagos.orden_trabajo_id')
            ->whereBetween('ordenes_trabajo.created_at', [$start, $end])
            ->select(
                DB::raw('SUM(ordenes_trabajo.monto) - COALESCE(SUM(orden_trabajo_pagos.monto), 0) as pendiente')
            )
            ->first()->pendiente ?? 0;

        $this->totalPagado = DB::table('ordenes_trabajo')
            ->join('orden_trabajo_pagos', 'ordenes_trabajo.id', '=', 'orden_trabajo_pagos.orden_trabajo_id')
            ->whereBetween('ordenes_trabajo.created_at', [$start, $end])
            ->sum('orden_trabajo_pagos.monto');

        return [
            'destajos' => $destajos->paginate(50),
        ];
    }

    private function getDateRange()
    {
        $start = Carbon::now()->setISODate($this->year, $this->weekStart)->startOfWeek();
        $end = Carbon::now()->setISODate($this->year, $this->weekStart)->endOfWeek();
        return [$start, $end];
    }
} 