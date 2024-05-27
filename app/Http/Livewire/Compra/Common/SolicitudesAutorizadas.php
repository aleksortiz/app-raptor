<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\SolicitudCompra;
use Livewire\Component;

class SolicitudesAutorizadas extends Component
{
    public $selectedSolicitudes;

    protected $rules = [
        'selectedSolicitudes.*.selected' => 'bool',
    ];

    public function render()
    {
        return view('livewire.compra.common.solicitudes-autorizadas',[
            'solicitudes' => SolicitudCompra::where('canceled_at', null)
            ->where('estatus', 'AUTORIZADO')->get(),
        ]);
    }
}
