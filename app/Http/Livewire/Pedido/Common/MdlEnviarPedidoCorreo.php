<?php

namespace App\Http\Livewire\Pedido\Common;

use App\Http\Controllers\PedidoController;
use App\Models\Pedido;
use Livewire\Component;

class MdlEnviarPedidoCorreo extends Component
{
    public $mdlName = 'mdlEnviarPedidoCorreo';

    public $pedido;
    public $inputMails;
    public $inputMailBody;

    protected $listeners = [
        'initMdlEnviarPedidoCorreo',
    ];

    public function initMdlEnviarPedidoCorreo(Pedido $pedido, $mail, $body){
        $this->pedido = $pedido;
        $this->inputMails = $mail;
        $this->inputMailBody = $body;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function render()
    {
        return view('livewire.pedido.common.mdl-enviar-pedido-correo');
    }

    public function send(){
        $res = PedidoController::enviarCorreo($this->pedido, $this->inputMailBody, $this->inputMails);
        if($res){
            $estatus = $this->pedido->estatus == 'CREADO' ? 'ENVIADO' : $this->pedido->estatus;
            Pedido::where('id', $this->pedido->id)->update(['estatus' => $estatus]);
        }
        $this->emit('ok','Se ha enviado pedido');
        $this->emit('closeModal', "#{$this->mdlName}");

    }
}

