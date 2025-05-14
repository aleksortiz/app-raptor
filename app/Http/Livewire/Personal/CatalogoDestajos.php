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

    protected $queryString = ['year', 'weekStart'];

    public function updated()
    {
        $this->resetPage();
        // Add a small delay to make loading state visible
        usleep(500000); // 500ms delay
    }

    public function mount()
    {
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
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

        $destajos = OrdenTrabajo::select(
            'personal_id',
            DB::raw('COUNT(*) as total_ordenes'),
            DB::raw('SUM(monto) as monto_total'),
            DB::raw('SUM(CASE WHEN EXISTS (SELECT 1 FROM orden_trabajo_pagos WHERE orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id) THEN monto ELSE 0 END) as monto_pagado'),
            DB::raw('SUM(CASE WHEN NOT EXISTS (SELECT 1 FROM orden_trabajo_pagos WHERE orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id) THEN monto ELSE 0 END) as monto_pendiente')
        )
        ->with('personal')
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('personal_id')
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