<?php

namespace App\Http\Livewire\Business;

use App\Models\Costo;
use App\Models\Entrada;
use App\Models\EntradaMaterial;
use App\Models\GastoFijoLog;
use App\Models\OrdenTrabajoPago;
use App\Models\PagoPersonal;
use App\Models\Pedido;
use Carbon\Carbon;
use Livewire\Component;

class ReporteFacturas extends Component
{

    public $week;
    public $year;
    public $maxYear;

    protected $queryString = ['week', 'year'];

    public function mount(){
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->week = $this->week ? $this->week : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.business.reporte-facturas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $costos = Costo::all();

        return [
            'servicios' => $costos
        ];
    }
}
