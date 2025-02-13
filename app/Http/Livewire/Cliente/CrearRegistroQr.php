<?php

namespace App\Http\Livewire\Cliente;

use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearRegistroQr extends Component
{
    use WithFileUploads;

    public $cliente_nombre;
    public $numero_reporte;
    public $telefono;
    public $correo;
    public $marca;
    public $modelo;
    public $year;

    public $fecha_cita;
    public $hora_cita;

    public $ine_frontal;
    public $ine_trasera;
    public $orden_admision;

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
            'horas' => ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
        ];
    }

    public function aceptar(){
        // $this->emit('ok', 'Registro creado correctamente');
    }




}
