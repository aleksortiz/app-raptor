<?php

namespace App\Http\Livewire\Personal;

use App\Models\Entrada;
use App\Models\EntradaMaterial;
use App\Models\FaltaPersonal;
use App\Models\PagoPersonal;
use App\Models\Personal;
use Carbon\Carbon;
use Livewire\Component;

class DiagramaNomina extends Component
{

    public $dates;
    public $days = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
    public $selected_personal;
    public $selected_date;

    public $entradas = [];
    public $entradaKeyWord;
    public $searchFolio = false;
    public $searchFolioOver = false;

    public $porcentajes;
    public $materiales = [];

    public $week;
    public $year;
    public $maxYear;

    protected $listeners = ['deletePay', 'quitarFalta'];

    protected $rules = [
        'porcentajes.*' => 'number|min:0|max:100',
    ];

    protected $queryString = ['week', 'year'];

    public function mount()
    {
        $today = Carbon::today();
        $this->maxYear = $today->year;
        $this->week = $this->week ? $this->week : $today->weekOfYear;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function getTotalNominaProperty()
    {
        $total = 0;
        foreach($this->getRenderData()['personal'] as $personal){
            // $total += $personal->getPagos
            foreach($this->dates as $date){
                $total += $personal->getPagos($date)->sum('pago');
            }
        }
        return $total;
    }

    public function getTotalMaterialesProperty(){
        $startDate = $this->dates[0];
        $endDate = $this->dates[5];
        $pagos = PagoPersonal::where('fecha', '>=', $startDate)
        ->where('fecha', '<=', $endDate)->whereNotNull('entrada_id')->get();
        
        $total = 0;
        $uniqueIds = [];
        foreach($pagos as $pago){
            if(in_array($pago->entrada->id, $uniqueIds)){
                continue;
            }
            $total += $pago->entrada->total_materiales($startDate, $endDate);
            $uniqueIds[] = $pago->entrada->id;
        }

        return $total;
    }

    public function mdlMaterialesDetalle(){
        $this->materiales = [];

        $startDate = $this->dates[0];
        $endDate = $this->dates[5];
        $pagos = PagoPersonal::where('fecha', '>=', $startDate)
        ->where('fecha', '<=', $endDate)->whereNotNull('entrada_id')->get();
        
        $materiales = [];
        $uniqueIds = [];
        $materialesIds = [];
        foreach($pagos as $pago){
            if(in_array($pago->entrada->id, $uniqueIds)){
                continue;
            }
            $materiales = $pago->entrada->materiales()->whereBetween('created_at', [$startDate, $endDate])->get();
            foreach($materiales as $material){
                if(in_array($material->id, $materialesIds)){
                    continue;
                }
                $materiales[] = $material;
                $materialesIds[] = $material->id;
            }
            $uniqueIds[] = $pago->entrada->id;
        }

        // $this->materiales = $materiales;
        $this->materiales = collect($materiales)->unique('id')->values();
        $this->emit('showModal','#mdlDetalleMaterial');

    }

    public function fecha_creacion($date){
        $date = Carbon::parse($date);
        $format = 'M/d/Y h:i A';
        if ($date->year = Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function render()
    {
        $start = Entrada::getDateRange($this->year, $this->week, $this->week);
        $start = Carbon::parse($start[0]);
        $this->dates = [
            $start->format('Y-m-d'),
            $start->addDays(1)->format('Y-m-d'),
            $start->addDays(1)->format('Y-m-d'),
            $start->addDays(1)->format('Y-m-d'),
            $start->addDays(1)->format('Y-m-d'),
            $start->addDays(1)->format('Y-m-d'),
        ];

        return view('livewire.personal.diagrama-nomina.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        return [
            'personal' => Personal::where('activo', true)->get(),
        ];
    }

    public function addPay($personal_id, $date)
    {
        $this->selected_personal = Personal::findOrFail($personal_id);
        $this->selected_date = $date;

        // $this->emit('ok', "Se ha agregado el pago para el personal {$this->selected_personal} en la fecha {$this->selected_date}");
        $this->emit('showModal','#mdlEntradas');
    }

    public function searchEntradas()
    {
        $this->porcentajes = [];
        if($this->entradaKeyWord && strlen($this->entradaKeyWord) > 4){
            $this->entradas = Entrada::OrderBy('id','desc')
            ->where('folio','like',"%{$this->entradaKeyWord}%")
            ->get();
        }else{
            $this->entradas = [];
        }

    }

    public function selectEntrada($entrada_id){
        $isOver = $this->searchFolioOver;
        $porcentaje = $this->porcentajes[$entrada_id] ?? 0;

        $limit = 100 - $this->selected_personal?->getPorcentaje($this->selected_date);

        if(($porcentaje > 0 && $porcentaje <= $limit) || ($isOver)){

            if($isOver){
                $pago = $porcentaje ?? 0;
                $porcentaje = 0;
            }
            else{
                $pago = $this->selected_personal->sueldo_diario * ($porcentaje / 100);
            }

            if($pago <= 0){
                $this->emit('info', "El pago debe ser mayor a 0");
                return;
            }

            PagoPersonal::create([
                'fecha' => $this->selected_date,
                'personal_id' => $this->selected_personal->id,
                'entrada_id' => $entrada_id == 0 ? null : $entrada_id,
                'porcentaje' => $porcentaje,
                'pago' => $pago,
            ]);
            $this->emit('ok', "Se ha agregado el pago para el personal {$this->selected_personal->nombre} en la fecha {$this->selected_date}");
            $this->searchFolio = false;
            $this->searchFolioOver = false;
            $this->entradas = [];
            $this->entradaKeyWord = '';
            $this->porcentajes = array_fill_keys(array_keys($this->porcentajes) , '');
        }else{
            $this->emit('info', "El porcentaje debe ser mayor a 0 y menor o igual a $limit");
        }
        
    }

    public function deletePay($id)
    {
        $pago = PagoPersonal::findOrFail($id);
        $pago->delete();
        $this->emit('ok', "Se ha eliminado pago");
    }

    public function ponerFalta(){
        $falta = $this->selected_personal->getFalta($this->selected_date);
        if(!$falta){
            FaltaPersonal::create([
                'personal_id' => $this->selected_personal->id,
                'fecha' => $this->selected_date
            ]);
            $this->emit('closeModal','#mdlEntradas');
            $this->emit('ok', "Se ha agregado la falta para {$this->selected_personal->nombre} en la fecha {$this->selected_date}");
        }
    }

    public function quitarFalta($data){
        $parts = explode('#', $data);
        $personal_id = $parts[0];
        $date = $parts[1];

        $falta = Personal::findOrFail($personal_id)->getFalta($date);
        if($falta){
            $falta->delete();
            $this->emit('ok', "Se ha eliminado la falta para {$this->selected_personal->nombre} en la fecha {$this->selected_date}");
        }
    }

    public function setOverTime(){
        $this->searchFolio = true;
        $this->searchFolioOver = true;
    }

    public function setNormalTime(){
        $this->searchFolio = true;
        $this->searchFolioOver = false;
    }


}
