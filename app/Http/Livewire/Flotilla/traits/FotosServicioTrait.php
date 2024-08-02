<?php

namespace App\Http\Livewire\Flotilla\traits;

use App\Models\ServicioFlotilla;

trait FotosServicioTrait {
    
    public function mdlFotosServicio($servicio_id){
        $modelName = 'App\\Models\\ServicioFlotilla'; 
        $this->emit('loadFotos', $servicio_id, $modelName);
        $this->emit('showModal', '#mdlFotosServicio');
    }

}