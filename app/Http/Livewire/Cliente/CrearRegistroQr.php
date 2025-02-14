<?php

namespace App\Http\Livewire\Cliente;

use App\Mail\RegistroCitaMailable;
use App\Models\RegistroQr;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearRegistroQr extends Component
{
    use WithFileUploads;

    public $cliente_nombre;
    public $numero_reporte;
    public $tipo;
    public $telefono;
    public $correo;
    public $marca;
    public $modelo;
    public $year;
    public $color;

    public $fecha_cita_DB;

    public $fecha_cita;
    public $hora_cita;

    public $ine_frontal_file;
    public $ine_reverso_file;
    public $orden_admision_file;

    public $ine_frontal;
    public $ine_reverso;
    public $orden_admision;

    public $horas_disponibles;

    protected $rules = [
        'cliente_nombre' => 'required|string|max:255',
        'numero_reporte' => 'required|numeric|digits:11',
        'tipo' => 'required|string|max:255',
        'telefono' => 'required|numeric|digits:10',
        'correo' => 'nullable|email|max:255',
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'year' => 'required|numeric|digits:4',
        'color' => 'required|string|max:255',

        'fecha_cita' => 'required|date|after_or_equal:today',
        'hora_cita' => 'required|string',

        'ine_frontal_file' => 'nullable|image|max:8192',
        'ine_reverso_file' => 'nullable|image|max:8192',
        'orden_admision_file' => 'nullable|image|max:5120',
    ];

    public function render(){
        return view('livewire.cliente.crear-registro-qr.view', $this->getRenderData());
    }

    public function getRenderData(){
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);

        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
            // 'horas_disponibles' => ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
        ];
    }

    public function updatedFechaCita($value){
        $this->hora_cita = null;
        $this->horas_disponibles = $this->getHorasDisponibles();
    }

    public function updatedTipo($value){
        $this->fecha_cita = null;
        $this->hora_cita = null;
    }

    public function getHorasDisponibles()
    {
        $fecha = $this->fecha_cita;
        $fecha_actual = now(); // Obtiene la fecha y hora actual
        $fecha_cita = Carbon::parse($fecha); // Convierte la fecha a un objeto Carbon
        
        // Validar que la fecha sea de lunes a jueves
        $dia_semana = $fecha_cita->dayOfWeekIso; // 1 (lunes) - 7 (domingo)
        if ($dia_semana < 1 || $dia_semana > 4) {
            return []; // No hay horarios disponibles fuera de lunes a jueves
        }
    
        // Validar que la fecha y hora sean mayores a la fecha actual con 3 horas de diferencia
        if ($fecha_cita->isToday() && $fecha_cita->lt($fecha_actual->addHours(3))) {
            return []; // No permite citas con menos de 3 horas de anticipación el mismo día
        }
    
        // Definir horarios de atención excluyendo 1:00 PM - 2:00 PM
        $horarios_posibles = [];
        $hora_inicio = strtotime('08:30');
        $hora_fin = strtotime('16:00');
    
        while ($hora_inicio < $hora_fin) {
            $hora_actual = date('H:i', $hora_inicio);
    
            if ($hora_actual < '13:00' || $hora_actual >= '14:00') {
                $horarios_posibles[] = $hora_actual;
            }
    
            $hora_inicio = strtotime('+30 minutes', $hora_inicio);
        }
    
        // Obtener las horas ocupadas
        $horas_ocupadas = RegistroQr::whereDate('fecha_cita', $fecha)
            ->where('tipo', $this->tipo)
            ->pluck('fecha_cita')
            ->map(function ($fecha) {
                return date('H:i', strtotime($fecha)); // Extrae solo la hora en formato H:i
            })
            ->toArray();
    
        // Filtrar horarios disponibles y validar que sean mayores a la hora actual si es el mismo día
        $horas_disponibles = array_filter($horarios_posibles, function ($hora) use ($fecha_cita, $fecha_actual, $horas_ocupadas) {
            $hora_completa = Carbon::parse($fecha_cita->toDateString() . ' ' . $hora); // Genera la hora completa
    
            // Verificar que la hora no esté ocupada ni sea menor a la hora actual con 3 horas de diferencia
            return !in_array($hora, $horas_ocupadas) && $hora_completa->gt($fecha_actual->addHours(3));
        });
    
        return array_values($horas_disponibles);
    }

    public function convertTimeFormat($time){
        return date('g:i A', strtotime($time)); 
    }
    

    public function aceptar(){


        $this->validate([
            'cliente_nombre' => 'required|string|max:255',
            'numero_reporte' => 'required|numeric|digits:11',
            'tipo' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits:10',
            'correo' => 'nullable|email|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'year' => 'required|numeric|digits:4',
            'color' => 'required|string|max:255',
    
            'hora_cita' => 'required|string',
            'fecha_cita' => 'required|date|after_or_equal:today',
    
            'ine_frontal_file' => 'nullable|image|max:8192',
            'ine_reverso_file' => 'nullable|image|max:8192',
            'orden_admision_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $this->fecha_cita_DB = new DateTime($this->fecha_cita . ' ' . $this->hora_cita);

        $exists = RegistroQr::where('tipo', $this->tipo)
        ->where('fecha_cita', $this->fecha_cita_DB)
        ->exists();

        if($exists){
            $this->emit('info', 'Ya existe una cita programada a esa hora');
            return;
        }
        
        $registro_qr = RegistroQr::create([
            'cliente_nombre' => $this->cliente_nombre,
            'numero_reporte' => $this->numero_reporte,
            'tipo' => $this->tipo,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'year' => $this->year,
            'color' => $this->color,
            'fecha_cita' => $this->fecha_cita_DB,
        ]);

        if($registro_qr && $registro_qr->correo){
            $mailable = new RegistroCitaMailable($registro_qr);
            Mail::to($registro_qr->correo)->queue($mailable);
        }
        else{
            $this->emit('error', 'Ocurrió un error al crear el registro');
            return;
        }

        if($this->ine_frontal_file){
            $fileName = $this->ine_frontal_file->store('registros_qr', 's3');
            if ($fileName) {
                $location = env('AWS_BUCKET_URL') . $fileName;
                $registro_qr->ine_frontal = $location;
            }
        }

        if($this->ine_reverso_file){
            $fileName = $this->ine_reverso_file->store('registros_qr', 's3');
            if ($fileName) {
                $location = env('AWS_BUCKET_URL') . $fileName;
                $registro_qr->ine_reverso = $location;
            }
        }

        if($this->orden_admision_file){
            $fileName = $this->orden_admision_file->store('registros_qr', 's3');
            if ($fileName) {
                $location = env('AWS_BUCKET_URL') . $fileName;
                $registro_qr->orden_admision = $location;
            }
        }

        $registro_qr->save();
        $this->emit('ok', 'Registro creado exitosamente');
        $this->reset();


    }

    public function removePhoto($tipo){

        if($tipo == 'frontal'){
            $this->ine_frontal_file = null;
        }
        if($tipo == 'reverso'){
            $this->ine_reverso_file = null;
        }
        
    }

    public function removeOrdenAdmision(){
        $this->orden_admision_file = null;
    }




}
