<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\SolicitudCompra;
use App\Models\StatusLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BtnDetalles extends Component
{
    public SolicitudCompra $solicitud;

    public $autorizar = false;
    public $rechazar = false;
    
    public $comentarios;

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
    ];
    
    public function mount(SolicitudCompra $solicitud){
        $this->solicitud = $solicitud;
    }

    public function render()
    {
        return view('livewire.compra.common.btn-detalles');
    }

    public function autorizar(){
        $this->solicitud->authorized_by = Auth::user()->id;
        $this->solicitud->estatus = 'AUTORIZADO';

        if($this->solicitud->save()){
            $this->log();
            $this->emit('ok', 'Se ha autorizado solicitud', 'Autorizado');
            $this->emit('closeModal');
            $this->emit('loadSolicitudes');
        }
    }

    public function rechazar(){
        $this->validate();
        $this->solicitud->estatus = 'RECHAZADO';
        if($this->solicitud->save()){
            $this->log();
            $this->emit('error', 'Se ha rechazado solicitud', 'Rechazado');
            $this->emit('closeModal');
            $this->emit('loadSolicitudes');
        }
    }

    public function log(){
        StatusLog::create([
            'model_id' => $this->solicitud->id,
            'model_type' => SolicitudCompra::class,
            'status' => $this->solicitud->estatus,
            'comments' => $this->comentarios,
        ]);
    }
}
