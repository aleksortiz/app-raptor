<?php

namespace App\Http\Livewire\Personal;

use App\Models\Personal;
use App\Models\Prestamo;
use Carbon\Carbon;
use Livewire\Component;

class MdlCrearPrestamo extends Component
{
    public $mdlName = 'mdlCrearPrestamo';

    public $personal_id;
    public $monto;
    public $cuotas = 1;
    public $inicia;
    public $year;
    public $week;

    protected $rules = [
        'personal_id' => 'required|exists:personal,id',
        'monto' => 'required|numeric|min:10|max:50000',
        'cuotas' => 'required|numeric|min:1|max:100',
        'inicia' => 'required|date|after:yesterday',
        'week' => 'required|numeric|min:1|max:52',
        'year' => 'required|numeric|min:2025|max:2090',
    ];

    public function mount(){
        $this->year = Carbon::today()->addWeek()->endOfWeek()->format('Y');
        $this->week = Carbon::today()->addWeek()->endOfWeek()->format('W');
    }


    public function render()
    {
        return view('livewire.personal.mdl-crear-prestamo', $this->getRenderData());
    }

    public function getRenderData(){
        $personal = Personal::where('activo', 1)->orderBy('nombre')->get();

        return [
            'personal' => $personal,
        ];
    }

    public function create(){
        $this->validate([
            'week' => 'required|numeric|min:1|max:52',
            'year' => 'required|numeric|min:2025|max:2090',
        ]);

        $this->inicia = Carbon::today()->setISODate($this->year, $this->week, 6);
        $this->validate();

        $prestamo = Prestamo::create([
            'personal_id' => $this->personal_id,
            'monto' => $this->monto,
            'cuotas' => $this->cuotas,
            'inicia' => $this->inicia,
        ]);

        $this->reset();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit('reloadPrestamos');
        $this->emit('ok', 'Se ha registrado el préstamo');
        $this->emit('print', "prestamo#{$prestamo->id}");

    }

    public function getCuotaSemanalProperty(){
        if(!$this->cuotas || $this->cuotas == "0"){
            return 0;
        }
        $cuota = $this->monto / $this->cuotas;
        return number_format($cuota, 2);
    }


}
