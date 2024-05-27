<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\Proyecto;
use App\Models\SolicitudCompra;
use Livewire\Component;

class BtnSelectSolicitudesCompra extends Component
{
    public Proyecto $proyecto;

    public $selectedSolicitudes;

    protected $rules = [
        'selectedSolicitudes.*.selected' => 'bool',
    ];

    public function mount(Proyecto $proyecto){
        $this->proyecto = $proyecto;
    }

    public function render()
    {
        return view('livewire.compra.common.btn-select-solicitudes-compra',[
            'solicitudes' => $this->proyecto->solicitudes_compra
            ->where('estatus', 'AUTORIZADO')
            ->where('canceled_at', null),
        ]);
    }
}
