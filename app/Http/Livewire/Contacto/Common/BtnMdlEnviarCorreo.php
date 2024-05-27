<?php

namespace App\Http\Livewire\Contacto\Common;

use App\Http\Controllers\ComprasController;
use App\Models\EnvioCorreo;
use App\Models\OrdenCompra;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BtnMdlEnviarCorreo extends Component
{
    public $model;
    public $provider;
    public $contactos;
    public $cardTitle;
    public $asuntoCorreo;
    public $mensajeCorreo;

    public $selectedContactos;

    protected $rules = [
        'selectedContactos.*.send' => 'boolean'
    ];

    public function render()
    {
        return view('livewire.contacto.common.btn-mdl-enviar-correo');
    }

    public function enviarCorreo(){
        $sendto = array_filter($this->selectedContactos, function($item){
            return $item['send'];
        });

        if(count($sendto) == 0){
            $this->emit('info', 'No hay contactos seleccionados', 'Seleccione Contactos');
            return;
        }

        $envio = new EnvioCorreo([
            'titulo' => $this->asuntoCorreo,
            'mensaje' => $this->mensajeCorreo,
            'usuario_id' => Auth::user()->id,
            'model_type' => get_class($this->model),
            'model_id' => $this->model->id,
        ]);
        
        if(ComprasController::enviarCorreo($this->model, array_keys($sendto), $envio)){ // ORDEN DE COMPRACONTROLLER DEBE SER GENERICO
            $this->emit('ok', 'Se ha enviado presupuesto');
            $this->emit('closeModal');
            $this->emit('loadOrdenes');
        }
        else{
            $this->emit('error', 'Error al enviar presupuesto');
        }
    }
}
