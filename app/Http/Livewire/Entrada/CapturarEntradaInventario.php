<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Aseguradora;
use App\Models\Cliente;
use App\Models\Costo;
use App\Models\Entrada;
use App\Models\Fabricante;
use App\Models\Refaccion;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CapturarEntradaInventario extends Component
{
    public Entrada $entrada;

    public function mount(Entrada $entrada){
        $this->entrada = $entrada;
    }

    public function render(){
        return view('livewire.entrada.capturar-entrada-inventario.view', $this->getRenderData());
    }

    public function getRenderData(){
        return [
            // 'sucursales' => Sucursal::allActive(),
            // 'aseguradoras' => Aseguradora::OrderBy('nombre')->get(),
            // 'fabricantes' => Fabricante::OrderBy('nombre')->get(),
        ];
    }

}
