<?php

namespace App\Http\Livewire\RegistroQr;

use App\Models\RegistroQr;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class MdlVerRegistroQr extends Component
{
    public $mdlName = 'mdlVerRegistroQr';

    public $registro_qr;

    protected $listeners = ['initMdlVerRegistroQr', 'deleteRegistro'];

    public function render()
    {
        return view('livewire.registro-qr.mdl-ver-registro-qr');
    }

    public function initMdlVerRegistroQr($id)
    {
        $this->registro_qr = RegistroQr::FindOrFail($id);
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function download_orden_admision(){
        return Storage::disk('s3')->download($this->registro_qr?->orden_admision_location);
    }

    public function downloadIneFrontal(){
        return Storage::disk('s3')->download($this->registro_qr?->ine_frontal_location);
    }

    public function download_ine_reverso(){
        return Storage::disk('s3')->download($this->registro_qr?->ine_reverso_location);
    }

    public function deleteRegistro($id){
        $registro = RegistroQr::FindOrFail($id);

        if($registro->orden_admision){
            Storage::disk('s3')->delete($registro->orden_admision_location);
        }
        if($registro->ine_frontal){
            Storage::disk('s3')->delete($registro->ine_frontal_location);
        }
        if($registro->ine_reverso){
            Storage::disk('s3')->delete($registro->ine_reverso_location);
        }

        $registro->delete();
        $this->emit('ok', 'Cita eliminada correctamente');
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit('reloadCatalogoCitas');
    }
}
