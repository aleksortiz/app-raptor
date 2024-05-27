<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\OrdenCompra;
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesPendientes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'loadOrdenes' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.compra.common.ordenes-pendientes',[
            'ordenes_pend' => OrdenCompra::where('canceled_at', null)
            ->where('estatus', 'PENDIENTE AUTORIZAR')->paginate(20, ['*'], 'pagePendientes'),
        ]);
    }
}
