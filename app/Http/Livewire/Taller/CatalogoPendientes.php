<?php

namespace App\Http\Livewire\Taller;

use App\Models\Entrada;
use App\Models\Pendiente;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class CatalogoPendientes extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id_search;
    public $solo_pendientes = false;
    public $user_id;
    public $fecha_promesa;
    public $descripcion;

    public $weekStart;
    public $weekEnd;
    public $year;

    protected $listeners = [
        'check'
    ];

    protected $queryString = ['weekStart', 'weekEnd'];

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->fecha_promesa = Carbon::now()->addHour(2)->setMinute(0)->setSecond(0)->toDateTimeString();
        $this->weekStart = Carbon::now()->startOfWeek()->week();
        $this->weekEnd = $this->weekStart;
        $this->year = Carbon::today()->startOfWeek()->year;
    }

    public function getPendientesCountProperty()
    {
        $pendientesCount = Pendiente::where('fecha_terminado', null)->count();
        return $pendientesCount;
    }

    public function updatedWeekStart()
    {
        if($this->weekStart > $this->weekEnd){
            $this->weekEnd = $this->weekStart;
        }
    }

    public function check($id){

        $pendiente = \App\Models\Pendiente::find($id);
        if ($pendiente) {
            $pendiente->update([
                'fecha_terminado' => Carbon::now(),
            ]);
            $this->emit('ok', 'Pendiente marcado como terminado');
        } else {
            $this->emit('error', 'Pendiente no encontrado');
        }
    }

    public function getTiempoRestanteProperty(){
        if (!$this->fecha_promesa) {
            return null;
        }
    
        $fecha = Carbon::parse($this->fecha_promesa);
        $ahora = Carbon::now();
    
        if ($fecha->lessThan($ahora)) {
            return 'No válido';
        }
    
        $diff = $ahora->diff($fecha);
    
        $dias = $diff->d;
        $horas = $diff->h;
        $minutos = $diff->i;
    
        $partes = [];
    
        if ($dias > 0) {
            $partes[] = $dias . ' ' . Str::plural('día', $dias);
        }
    
        if ($horas > 0) {
            $partes[] = $horas . ' ' . Str::plural('Hora', $horas);
        }
    
        // Solo mostrar minutos si faltan menos de 3 horas en total
        if ($dias === 0 && $diff->h < 3 && $minutos > 0) {
            $partes[] = $minutos . ' Mins';
        }
    
        return 'Dentro de ' . implode(' y ', $partes);
    }
    
    public function crearPendiente(){
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'fecha_promesa' => 'required|date|after:now',
            'descripcion' => 'required|string|max:255',
        ]);

        \App\Models\Pendiente::create([
            'user_id' => $this->user_id,
            'fecha_promesa' => $this->fecha_promesa,
            'descripcion' => $this->descripcion,
        ]);

        $this->reset(['user_id', 'fecha_promesa', 'descripcion']);
        $this->user_id = auth()->user()->id;
        $this->fecha_promesa = Carbon::now()->addHour(2)->setMinute(0)->setSecond(0)->toDateTimeString();

        $this->emit('closeModal','#mdlCrearPendiente');
        $this->emit('ok', 'Pendiente creado con éxito');
    }

    public function render()
    {
        return view('livewire.taller.catalogo-pendientes.view', $this->getRenderData());
    }

    public function getUsers()
    {
        return \App\Models\User::paginate();
    }

    public function getPendientes()
    {
        [$start, $end] = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);

        $pendientes = Pendiente::whereBetween('created_at', [$start, $end]);
        if($this->user_id_search){
            $pendientes = $pendientes->where('user_id', $this->user_id_search);
        }
        if($this->solo_pendientes){
            $pendientes = $pendientes->where('fecha_terminado', null);
        }

        return $pendientes->paginate(30);
    }

    public function getRenderData()
    {
        return [
            'pendientes' => $this->getPendientes(),
            'users' => $this->getUsers(),
        ];
    }

    public function getFechaPromesaProperty()
    {
        return Carbon::parse($this->fecha_promesa)->format('Y-m-d H:i:s');
    }

}
