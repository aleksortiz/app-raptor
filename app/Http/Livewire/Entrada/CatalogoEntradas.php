<?php

namespace App\Http\Livewire\Entrada;

use App\Http\Traits\StatusButtonsTrait;
use App\Models\Costo;
use App\Models\Entrada;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoEntradas extends Component
{
    use StatusButtonsTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyWord;
    public $model_name = "Entrada";
    public $model_name_plural = "Entradas";

    public $year;
    public $maxYear;
    public $weekStart;
    public $weekEnd;
    public $origen;
    public $filtroEnPiso = true;

    public $selectedEntrada;
    public $selectedCosto;
    public $editingProyeccion = false;
    public $proyeccionFecha;

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd', 'origen', 'filtroEnPiso'];

    protected $rules = [
        'selectedCosto.concepto' => 'string|required|max:255',
        'selectedCosto.costo' => 'numeric|required|min:0',
        'selectedCosto.no_factura' => 'string|nullable|max:255',
        'selectedCosto.pagado' => 'date',
        'proyeccionFecha' => 'date|nullable',
    ];

    protected $listeners = [
        'pagarRefacciones',
        'pagarEntrada',
        'entregarVehiculo',
        'reloadOrdenesTrabajo' => '$refresh'
    ];

    public function mount(){
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function resetInput(){
    }

    public function render()
    {
        return view('livewire.entrada.catalogo-entradas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $this->keyWord = trim($this->keyWord);
        
        $entradas = Entrada::OrderBy('id','asc');

        if (!$this->filtroEnPiso) {
            [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
            $entradas = $entradas->whereBetween('created_at', [$start, $end]);
        }

        $baseQuery = $entradas->when($this->filtroEnPiso, function($query) {
            return $query->whereNull('fecha_entrega');
        })
        ->where(function ($q){
            $q->orWhere('modelo', 'LIKE', "%{$this->keyWord}%")
            ->orWhereHas('cliente', function($fab){
                $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
            })
            ->orWhere('marca', 'LIKE', "{$this->keyWord}%")
            ->orWhere('folio', 'LIKE', "{$this->keyWord}%")
            ->orWhere('serie', 'LIKE', "{$this->keyWord}%")
            ->orWhere('orden', 'LIKE', "%{$this->keyWord}%")
            ->orWhere(DB::raw('REPLACE(orden, " ", "")'), 'LIKE', trim($this->keyWord).'%');
        });

        if($this->origen){
            $baseQuery = $baseQuery->where('origen', $this->origen);
        }

        // Entregas de hoy
        $entregasHoy = (clone $baseQuery)
            ->whereNotNull('proyeccion_entrega')
            ->where('proyeccion_entrega', '<=', now()->toDateString())
            ->whereNull('fecha_entrega')
            ->paginate(50);

        // Resto de entradas
        $otrasEntradas = (clone $baseQuery)
            ->where(function($query) {
                $query->whereNull('proyeccion_entrega')
                    ->orWhere('proyeccion_entrega', '>', now()->toDateString())
                    ->orWhereNotNull('fecha_entrega');
            })
            ->paginate(50);

        return [
            'entregasHoy' => $entregasHoy,
            'otrasEntradas' => $otrasEntradas,
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

    public function toggleProyeccion($entradaId)
    {
        $entrada = Entrada::findOrFail($entradaId);
        
        if ($entrada->proyeccion_entrega) {
            $this->editingProyeccion = true;
            $this->selectedEntrada = $entrada;
            $this->proyeccionFecha = $entrada->proyeccion_entrega;
            $this->emit('showModal', '#mdlProyeccionEntrega');
        } else {
            $entrada->update([
                'proyeccion_entrega' => now()->toDateString()
            ]);
            $this->emit('ok', 'Se ha establecido la fecha de entrega para hoy');
        }
    }

    public function saveProyeccion()
    {
        $this->validate([
            'proyeccionFecha' => 'required|date'
        ]);

        $this->selectedEntrada->update([
            'proyeccion_entrega' => $this->proyeccionFecha
        ]);

        $this->editingProyeccion = false;
        $this->selectedEntrada = null;
        $this->proyeccionFecha = null;
        $this->emit('closeModal', '#mdlProyeccionEntrega');
        $this->emit('ok', 'Se ha actualizado la fecha de entrega');
    }

    public function removeProyeccion()
    {
        $this->selectedEntrada->update([
            'proyeccion_entrega' => null
        ]);
        $this->editingProyeccion = false;
        $this->selectedEntrada = null;
        $this->proyeccionFecha = null;
        $this->emit('closeModal', '#mdlProyeccionEntrega');
        $this->emit('ok', 'Se ha eliminado la proyección de entrega');
    }

    public function cancelProyeccion()
    {
        $this->editingProyeccion = false;
        $this->selectedEntrada = null;
        $this->proyeccionFecha = null;
        $this->emit('closeModal', '#mdlProyeccionEntrega');
    }

    public function showMdlCrearOrdenTrabajo($id)
    {
        $this->emit('initMdlCrearOrdenTrabajo', $id);
    }

}
