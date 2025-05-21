<?php

namespace App\Http\Livewire\EntradaInventario;

use App\Models\EntradaInventario;
use Livewire\Component;

class TomarFotosInventario extends Component
{

    public $entrada;
    public $inventario;

    public $firma = true;

    protected $listeners = ['saveSign'];

    public function mount(EntradaInventario $inventario){
        $this->inventario = $inventario;
        $this->entrada = $inventario->entrada;
    }

    public function render()
    {
        return view('livewire.entrada-inventario.tomar-fotos-inventario.view');
    }

    public function fotos(){
      $this->firma = false;
    }

    public function firmar(){
        $this->firma = true;

        if($this->firma){
            $this->emit('init-canvas');
        }
    }

    public function guardarFirma(){
      $this->emit('guardar-firma');
    }

    public function saveSign($image){
        $this->inventario->firma = $image;
        $this->inventario->save();
        $this->emit('ok', 'Firma guardada correctamente');
        return redirect()->to('/');
    }


}
