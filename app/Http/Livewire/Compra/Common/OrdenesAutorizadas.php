<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\OrdenCompra;
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesAutorizadas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    protected $listeners = [
        'loadOrdenes' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.compra.common.ordenes-autorizadas',[
            'ordenes_aut' => OrdenCompra::where('canceled_at', null)
            ->where('estatus', 'AUTORIZADO')->paginate(20, ['*'], 'pageAutorizadas'),
        ]);
    }
}
