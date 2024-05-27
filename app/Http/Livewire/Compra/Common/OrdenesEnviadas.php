<?php

namespace App\Http\Livewire\Compra\Common;

use App\Models\OrdenCompra;
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesEnviadas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    protected $listeners = [
        'loadOrdenes' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.compra.common.ordenes-enviadas',[
            'ordenes_env' => OrdenCompra::where('canceled_at', null)
            ->where('estatus', 'ENVIADO')->paginate(20, ['*'], 'pageEnviadas'),
        ]);
    }
}
