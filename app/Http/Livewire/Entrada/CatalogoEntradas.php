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

    public $selectedEntrada;
    public $selectedCosto;

    protected $queryString = ['keyWord', 'year', 'weekStart', 'weekEnd'];

    protected $rules = [
        'selectedCosto.concepto' => 'string|required|max:255',
        'selectedCosto.costo' => 'numeric|required|min:0',
    ];

    protected $listeners = [
        'pagarRefacciones',
        'pagarEntrada',
        'entregarVehiculo',
    ];

    public function mount(){
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
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
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $entradas = Entrada::OrderBy('id','asc')
        ->whereBetween('created_at', [$start, $end])
        ->where(function ($q){
            $q->orWhere('modelo', 'LIKE', "%{$this->keyWord}%")
            ->orWhereHas('fabricante', function($fab){
                $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
            })
            ->orWhereHas('cliente', function($fab){
                $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
            })
            ->orWhere('folio', 'LIKE', "{$this->keyWord}%")
            ->orWhere('serie', 'LIKE', "{$this->keyWord}%")
            ->orWhere('orden', 'LIKE', "{$this->keyWord}%");
        });

        if($this->origen){
            $entradas = $entradas->where('origen', $this->origen);
        }

        $entradas = $entradas->paginate(50);

        return [
            'entradas' => $entradas,
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


}
