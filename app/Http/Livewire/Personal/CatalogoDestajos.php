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

        $pagos = DB::table('orden_trabajo_pagos')
        ->select('orden_trabajo_id')
        ->groupBy('orden_trabajo_id');
    
        $destajos = DB::table('ordenes_trabajo')
        ->leftJoinSub($pagos, 'pagos', function ($join) {
            $join->on('pagos.orden_trabajo_id', '=', 'ordenes_trabajo.id');
        })
        ->select(
            'ordenes_trabajo.personal_id',
            DB::raw('COUNT(*) as total_ordenes'),
            DB::raw('SUM(ordenes_trabajo.monto) as monto_total'),
            DB::raw('SUM(CASE WHEN pagos.orden_trabajo_id IS NOT NULL THEN ordenes_trabajo.monto ELSE 0 END) as monto_pagado'),
            DB::raw('SUM(CASE WHEN pagos.orden_trabajo_id IS NULL THEN ordenes_trabajo.monto ELSE 0 END) as monto_pendiente')
        )
        ->whereBetween('ordenes_trabajo.created_at', [$start, $end])
        ->groupBy('ordenes_trabajo.personal_id')
        ->orderBy('monto_total', 'desc');
    
    

        $this->totalPendiente = OrdenTrabajo::whereBetween('created_at', [$start, $end])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orden_trabajo_pagos')
                    ->whereRaw('orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id');
            })
            ->sum('monto');

        $this->totalPagado = OrdenTrabajo::whereBetween('created_at', [$start, $end])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orden_trabajo_pagos')
                    ->whereRaw('orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id');
            })
            ->sum('monto');

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