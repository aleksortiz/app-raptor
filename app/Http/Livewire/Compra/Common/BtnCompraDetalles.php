<?php

namespace App\Http\Livewire\Compra\Common;

use App\Http\Traits\ComentariosTrait;
use App\Models\Comentario;
use App\Models\OrdenCompra;
use App\Models\StatusLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BtnCompraDetalles extends Component
{
    use ComentariosTrait;

    public OrdenCompra $orden;
    
    public $autorizar = false;
    public $rechazar = false;
    
    public $activeTab = 1;
    public $comentarios;

    protected $listeners = [
        'loadContactos' => 'loadContactos',
    ];

    public function loadContactos(){
        $this->orden->load('contactos');
    }

    public function updated($name, $value)
    {
        if($name == 'autorizar'){
            if($this->autorizar){
                $this->rechazar = false;
                return;
            }
        }
        if($name == 'rechazar'){
            if($this->rechazar){
                $this->autorizar = false;
                return;
            }
        }
    }

    protected $rules = [
        'comentarios' => 'string|required|max:255',
        'comentario.mensaje' => 'string|min:10|max:255',
        'comentario.model_id' => 'numeric',
        'comentario.model_type' => 'string',
    ];
    
    public function mount(OrdenCompra $orden){
        $this->orden = $orden;
        $this->initComentario($this->orden->id, OrdenCompra::class);
    }

    public function loadComentarios(){
        $this->orden->load('comentarios');
    }

    public function render()
    {
        return view('livewire.compra.common.btn-compra-detalles.view');
    }

    public function autorizar(){
        $this->orden->authorized_by = Auth::user()->id;
        $this->orden->estatus = 'AUTORIZADO';

        if($this->orden->save()){
            $this->log();
            $this->emit('ok', 'Se ha autorizado orden', 'Autorizado');
            $this->emit('closeModal');
            $this->emit('loadOrdenes');
        }
    }

    public function rechazar(){
        $this->validate();
        $this->orden->estatus = 'RECHAZADO';
        if($this->orden->save()){
            $this->log();
            $this->emit('error', 'Se ha rechazado orden', 'Rechazado');
            $this->emit('closeModal');
            $this->emit('loadOrdenes');
        }
    }


    public function log(){
        StatusLog::create([
            'model_id' => $this->orden->id,
            'model_type' => OrdenCompra::class,
            'status' => $this->orden->estatus,
            'comments' => $this->comentarios,
        ]);
    }
}
