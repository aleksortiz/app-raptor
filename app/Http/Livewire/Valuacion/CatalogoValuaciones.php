<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Entrada;
use App\Models\Valuacion;
use App\Models\CitaReparacion;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoValuaciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['reloadCitasValuacion' => '$refresh'];

    public $start;
    public $end;
    public $year;
    public $maxYear;
    public $search = '';

    // Modal CitaReparacion
    public $showModalCita = false;
    public $valuacionId;
    public $clienteId;
    public $marca;
    public $modelo;
    public $noReporte;
    public $fechaCita;
    
    // Modal Entrada
    public $showModalEntrada = false;
    public $origen = 'ASEGURADORA';
    public $aseguradoraId = 6;
    public $serie;
    public $color;
    public $placas;
    public $yearVehiculo;
    public $tareaRealizar;
    
    protected $rules = [
        'fechaCita' => 'required|date',
        
        // Entrada rules
        'origen' => 'required',
        'aseguradoraId' => 'required',
        'marca' => 'required',
        'serie' => 'nullable',
        'placas' => 'nullable',
        'tareaRealizar' => 'nullable',
    ];

    protected $queryString = ['year', 'start', 'end', 'search'];

    public function updated(){
        $this->resetPage();
    }

    public function mount()
    {
        $this->start = $this->start ? $this->start : Carbon::today()->weekOfYear;
        $this->end = $this->end ? $this->end : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->endOfWeek()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function render()
    {
        return view('livewire.valuacion.catalogo-valuaciones.view', $this->getRenderData());
    }

    public function getRenderData(){
      $valuaciones = Valuacion::orderBy('id', 'desc');
      
      if (!empty($this->search)) {
          // Apply search filters
          $valuaciones->where(function($query) {
              $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('numero_reporte', 'like', '%' . $this->search . '%')
                  ->orWhere('modelo', 'like', '%' . $this->search . '%')
                  ->orWhere('marca', 'like', '%' . $this->search . '%');
          });
      } else {
          // Apply date range filters only if not searching
          $dates = Entrada::getDateRange($this->year, $this->start, $this->end);
          $valuaciones->whereBetween('created_at', $dates);
      }

      return [
        'valuaciones' => $valuaciones->paginate(50),
      ];
    }

    // Método para abrir modal de cita de reparación
    public function crearCitaReparacion($valuacionId)
    {
        $this->resetValidation();
        $this->reset(['marca', 'modelo', 'noReporte', 'fechaCita']);
        
        $valuacion = Valuacion::findOrFail($valuacionId);
        $this->valuacionId = $valuacionId;
        $this->clienteId = $valuacion->cliente_id;
        $this->marca = $valuacion->marca;
        $this->modelo = $valuacion->modelo;
        $this->color = $valuacion->color;
        $this->yearVehiculo = $valuacion->year;
        $this->noReporte = $valuacion->numero_reporte;
        $this->fechaCita = Carbon::now()->addDays(1)->format('Y-m-d\TH:i');
        
        $this->showModalCita = true;
        $this->emit('showModal', '#modalCitaReparacion');
    }

    // Método para guardar cita de reparación
    public function guardarCitaReparacion()
    {
        $this->validate([
            'fechaCita' => 'required|date',
        ]);
        
        CitaReparacion::create([
            'cliente_id' => $this->clienteId,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'no_reporte' => $this->noReporte,
            'cita' => $this->fechaCita,
            'valuacion_id' => $this->valuacionId,
        ]);
        
        $this->showModalCita = false;
        $this->emit('closeModal', '#modalCitaReparacion');
        $this->emit('ok', 'Cita de reparación creada correctamente');
        $this->emit('reloadCitasValuacion');
    }

    // Método para abrir modal de entrada
    public function crearEntrada($valuacionId)
    {
        $this->resetValidation();
        $this->reset(['marca', 'modelo', 'origen', 'aseguradoraId', 'serie', 'color', 'yearVehiculo', 'placas', 'tareaRealizar']);
        
        $valuacion = Valuacion::findOrFail($valuacionId);
        $this->valuacionId = $valuacionId;
        $this->clienteId = $valuacion->cliente_id;
        $this->marca = $valuacion->marca;
        $this->modelo = $valuacion->modelo;
        $this->color = $valuacion->color;
        $this->yearVehiculo = $valuacion->year;
        $this->noReporte = $valuacion->numero_reporte;
        $this->tareaRealizar = "REPARACIÓN SEGÚN VALUACIÓN #" . $valuacion->id;
        
        $this->showModalEntrada = true;
        $this->emit('showModal', '#modalCrearEntrada');
    }

    // Método para guardar entrada
    public function guardarEntrada()
    {
        $this->validate([
            'origen' => 'required',
            'marca' => 'required',
        ]);
        
        $entrada = Entrada::create([
            'user_id' => auth()->user()->id,
            'fabricante_id' => 1,
            'cliente_id' => $this->clienteId,
            'origen' => $this->origen,
            'aseguradora_id' => $this->aseguradoraId,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'color' => $this->color,
            'year' => $this->yearVehiculo,
            'serie' => $this->serie,
            'placas' => $this->placas,
            'orden' => $this->noReporte,
            'tarea_realizar' => $this->tareaRealizar,
        ]);
        
        // Actualizar la valuación con la entrada creada
        $valuacion = Valuacion::find($this->valuacionId);
        if ($valuacion) {
            $valuacion->entrada_id = $entrada->id;
            $valuacion->save();
        }
        
        $this->showModalEntrada = false;
        $this->emit('closeModal', '#modalCrearEntrada');
        $this->emit('ok', 'Entrada creada correctamente');
        $this->emit('reloadCitasValuacion');
    }
    
    public function cancelar()
    {
        $this->showModalCita = false;
        $this->showModalEntrada = false;
        $this->emit('closeModal');
    }
}
