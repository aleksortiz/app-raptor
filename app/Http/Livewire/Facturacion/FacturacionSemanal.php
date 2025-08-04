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

    public function mount()
    {
        // Set default year to current year
        $this->year = Carbon::now()->year;
        
        // Set default week to current week
        $this->weekNumber = Carbon::now()->weekOfYear;
        $this->currentWeek = $this->weekNumber;
        
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
            
            $this->emit('facturaActualizada');
        }
    }
    
    public function selectFactura($id)
    {
        $this->selectedFactura = RegistroFactura::find($id);
        if ($this->selectedFactura) {
            $this->notas = $this->selectedFactura->notas;
        }
    }
    
    public function saveNotas()
    {
        if ($this->selectedFactura) {
            $this->selectedFactura->notas = $this->notas;
            $this->selectedFactura->save();
            
            $this->emit('facturaActualizada');
            $this->emit('closeModal');
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
        
        // Build query
        $query = RegistroFactura::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('numero_factura', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('notas', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('model', function ($subquery) {
                      $subquery->where('folio', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        // Apply payment status filter
        if ($this->filterStatus === 'pagado') {
            $query->whereNotNull('fecha_pago');
        } elseif ($this->filterStatus === 'pendiente') {
            $query->whereNull('fecha_pago');
        }
        
        // Get data with pagination
        $facturas = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Calculate totals
        $totalMonto = $query->sum('monto');
        $totalPagado = $query->whereNotNull('fecha_pago')->sum('monto');
        $totalPendiente = $query->whereNull('fecha_pago')->sum('monto');
        
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
