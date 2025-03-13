<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\Entrada;
use App\Models\RegistroFactura;
use Livewire\Component;

class FacturasRegistradas extends Component
{
    public $search;

    
    public function render()
    {
        return view('livewire.facturacion.facturas-registradas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $this->search = trim($this->search);
        $facturas = RegistroFactura::orderBy('created_at', 'desc')
        ->where('numero_factura', 'LIKE', '%' . $this->search . '%')
        ->orWhere(function ($query) {
            $query->whereHasMorph('model', [Entrada::class], function ($query) {
                $query->where('orden', 'LIKE', '%' . $this->search . '%');
            });
        });

        return [
            'data' => $facturas->paginate(50),
        ];
    }
}
