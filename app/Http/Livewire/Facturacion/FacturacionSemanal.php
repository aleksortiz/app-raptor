<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\RegistroFactura;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class FacturacionSemanal extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $year;
    public $weekNumber;
    public $availableYears = [];
    public $currentWeek;
    public $searchTerm = '';
    public $filterStatus = 'all'; // 'all', 'pagado', 'pendiente'
    
    public $selectedFactura;
    public $notas;
    public $modalId = 'editNotasModal';

    // Sync weekNumber to the URL as ?week=
    protected $queryString = [
        'weekNumber' => ['as' => 'week'],
    ];

    public function mount()
    {
        // Set default year to current year
        $this->year = Carbon::now()->year;
        
        // Set default week to current week
        $this->weekNumber = Carbon::now()->weekOfYear;
        $this->currentWeek = $this->weekNumber;

        // If query string contains ?week=, prefer it
        $requestedWeek = request()->query('week');
        if ($requestedWeek !== null && is_numeric($requestedWeek)) {
            $requestedWeek = (int) $requestedWeek;
            // Clamp to 1..53 to avoid invalid ISO week numbers
            $this->weekNumber = max(1, min(53, $requestedWeek));
            $this->currentWeek = $this->weekNumber;
        }
        
        // Get available years from data
        $minYear = RegistroFactura::selectRaw('YEAR(created_at) as year')
            ->orderBy('year', 'asc')
            ->first();
            
        $maxYear = Carbon::now()->year;
        
        if ($minYear) {
            $minYear = $minYear->year;
            for ($i = $minYear; $i <= $maxYear; $i++) {
                $this->availableYears[] = $i;
            }
        } else {
            $this->availableYears = [$maxYear];
        }
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedWeekNumber()
    {
        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function previousWeek()
    {
        $date = Carbon::now()->setISODate($this->year, $this->weekNumber);
        $date->subWeek();
        $this->weekNumber = $date->weekOfYear;
        $this->year = $date->year;
    }

    public function nextWeek()
    {
        $date = Carbon::now()->setISODate($this->year, $this->weekNumber);
        $date->addWeek();
        $this->weekNumber = $date->weekOfYear;
        $this->year = $date->year;
    }

    public function markAsPaid($id)
    {
        $factura = RegistroFactura::find($id);
        if ($factura) {
            $factura->fecha_pago = $factura->fecha_pago ? null : Carbon::now();
            $factura->save();
            
            $this->emit('ok', 'La factura ha sido actualizada correctamente');
        }
    }
    
    public function selectFactura($id)
    {
        $this->selectedFactura = RegistroFactura::find($id);
        if ($this->selectedFactura) {
            $this->notas = $this->selectedFactura->notas;
            $this->emit('showModal', '#' . $this->modalId);
        }
    }
    
    public function saveNotas()
    {
        if ($this->selectedFactura) {
            $this->selectedFactura->notas = $this->notas;
            $this->selectedFactura->save();
            
            $this->selectedFactura = null;
            $this->notas = '';
            
            $this->emit('ok', 'Las notas han sido guardadas correctamente');
            $this->emit('closeModal', '#' . $this->modalId);
        }
    }

    public function render()
    {
        // Get start and end dates for the selected week
        $startDate = Carbon::now()->setISODate($this->year, $this->weekNumber)->startOfWeek();
        $endDate = Carbon::now()->setISODate($this->year, $this->weekNumber)->endOfWeek();
        
        // Format dates for display
        $startDateFormatted = $startDate->format('d/m/Y');
        $endDateFormatted = $endDate->format('d/m/Y');
        
        // Base query: week range + search term (do not include status filter here)
        $baseQuery = RegistroFactura::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if (!empty($this->searchTerm)) {
            $baseQuery->where(function ($q) {
                $q->where('numero_factura', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('notas', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('model', function ($subquery) {
                      $subquery->where('folio', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        // Listing query: start from base and apply status filter if any
        $listQuery = clone $baseQuery;
        if ($this->filterStatus === 'pagado') {
            $listQuery->whereNotNull('fecha_pago');
        } elseif ($this->filterStatus === 'pendiente') {
            $listQuery->whereNull('fecha_pago');
        }
        
        // Get data with pagination for the table
        $facturas = (clone $listQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calculate totals from a fresh clone each time to avoid condition accumulation
        $totalMonto = (clone $baseQuery)->sum('monto');
        $totalPagado = (clone $baseQuery)->whereNotNull('fecha_pago')->sum('monto');
        $totalPendiente = (clone $baseQuery)->whereNull('fecha_pago')->sum('monto');
        
        return view('livewire.facturacion.facturacion-semanal', [
            'facturas' => $facturas,
            'startDate' => $startDateFormatted,
            'endDate' => $endDateFormatted,
            'totalMonto' => $totalMonto,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
        ]);
    }
}
