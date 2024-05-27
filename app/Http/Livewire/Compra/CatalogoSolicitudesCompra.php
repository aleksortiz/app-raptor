<?php

namespace App\Http\Livewire\Compra;

use App\Models\Proyecto;
use App\Models\SolicitudCompra;
use Livewire\Component;

class CatalogoSolicitudesCompra extends Component
{
    public Proyecto $proyecto;

    protected $listeners = [
        'loadSolicitudes' => '$refresh',
    ];

    public function mount(Proyecto $proyecto){
        $this->proyecto = $proyecto;
    }

    public function render()
    {
        return view('livewire.compra.catalogo-solicitudes-compra',[
            'solicitudes' => SolicitudCompra::Where('proyecto_id', $this->proyecto->id)->get(),
        ]);
    }
}
