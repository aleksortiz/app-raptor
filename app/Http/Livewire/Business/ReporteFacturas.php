<?php

namespace App\Http\Livewire\Business;

use App\Http\Controllers\ReportController;
use App\Models\Costo;
use App\Models\Entrada;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteFacturas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyWord;

    public $selectedCosto;
    public $selectedEntrada;

    public $weekStart;
    public $weekEnd;
    public $year;
    public $maxYear;

    protected $queryString = ['weekStart', 'weekEnd', 'year', 'keyWord'];

    protected $rules = [
        'selectedCosto.concepto' => 'string|required|max:255',
        'selectedCosto.costo' => 'numeric|required|min:0',
        'selectedCosto.no_factura' => 'string|nullable|max:255',
        'selectedCosto.pagado' => 'date',
    ];

    public function updatedKeyWord(){
        $this->resetPage();
    }

    public function mount(){
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->weekStart = $this->weekStart ? $this->weekStart : $today->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.business.reporte-facturas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $costos = Costo::orderBy('pagado', 'asc');

        if($this->keyWord){
            $costos->whereHas('model', function($query){
                $query->where('orden', 'like', '%'.$this->keyWord.'%');
            });
        }else{
            $costos->whereBetween('pagado', $dates);
            $costos->orWhere('pagado', null);
        }

        $pagado = Costo::whereBetween('pagado', $dates)->get()->sum('costo');
        $pendiente = Costo::where('pagado', null)->get()->sum('costo');

        return [
            'servicios' => $costos->paginate(50),
            'pagado' => $pagado,
            'pendiente' => $pendiente,
        ];
    }

    public function mdlPagoServicios($id){
        $this->selectedEntrada = Entrada::findOrfail($id);
        $this->selectedCosto = null;
        $this->resetValidation();
        $this->emit('showModal', '#mdlPagoServicios');
    }

    public function editCosto($id)
    {
        $this->selectedCosto = Costo::findOrFail($id);
    }

    public function saveCosto()
    {
        $this->validate([
            'selectedCosto.concepto' => 'string|required|max:255',
            'selectedCosto.costo' => 'numeric|required|min:0',
            'selectedCosto.no_factura' => 'string|nullable|max:255',
            'selectedCosto.pagado' => 'date|nullable',
        ]);

        // $this->costo->model_id = $this->selectedEntrada->id;
        // $this->costo->model_type = Entrada::class;
        if ($this->selectedCosto->save()) {
            $this->selectedEntrada->load('costos');
            $this->selectedCosto = null;
        }
    }

    public function removeCosto(){
        $this->selectedCosto = null;
    }

    public function pagarServicio($costo_id)
    {
        $costo = Costo::findOrFail($costo_id);
        $costo->update([
            'pagado' => DB::raw('now()'),
        ]);
        $this->selectedEntrada->load('costos');
        $this->emit('ok', 'Se ha pagado servicio: ' . $costo->concepto);
    }

    public function eliminarPagoServicio($id){
        $costo = Costo::findOrFail($id);
        $costo->update([
            'pagado' => null,
        ]);
        $this->selectedEntrada->load('costos');
        $this->removeCosto();
        $this->emit('ok', 'Se ha eliminado pago de servicio: ' . $costo->concepto);
    }

    public function exportToExcel()
    {
        $data = $this->getData()->get();

        $headers = [
            'Folio',
            'Origen',
            'Vehículo',
            'Concepto',
            'Orden',
            'Venta',
            'Factura'
        ];

        $arrayData = $data->map(function ($item) {
            return [
                $item->model?->folio_short ?? '',
                $item->model?->origen_short ?? '',
                $item->model?->vehiculo ?? '',
                $item->concepto,
                $item->model?->orden ?? '',
                $item->costo,
                $item->no_factura,
            ];
        });
        $reportDate = date('Y-m-d');
        $fileName = "reporte_facturacion_{$reportDate}_.csv";
        return ReportController::downloadCSV($fileName, $headers, $arrayData);
    }
}
