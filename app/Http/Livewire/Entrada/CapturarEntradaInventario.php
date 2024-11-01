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
    public $firmar = false;

    protected $rules = [
        'entrada.inventario' => 'required|string',
        'entrada.color' => 'required|string',
        'entrada.placas' => 'required|string',
        'entrada.year' => 'required|numeric|digits:4',
        'entrada.kilometraje' => 'required|numeric',
        'entrada.gasolina' => 'required|numeric|min:1|max:100',
    ];

    protected $listeners = [
        'setGas',
    ];

    public function mount(){
      $this->entrada = new Entrada();
    }

    public function render(){
        return view('livewire.entrada.capturar-entrada-inventario.view', $this->getRenderData());
    }

    public function setGas($gasolina){
        $this->entrada->gasolina = $gasolina;
    }

    public function getRenderData(){
        return [
            // 'sucursales' => Sucursal::allActive(),
            // 'aseguradoras' => Aseguradora::OrderBy('nombre')->get(),
            // 'fabricantes' => Fabricante::OrderBy('nombre')->get(),
        ];
    }

    public function toggle(){

      $this->firmar = !$this->firmar;
      $this->emit('init-canvas');
    }

    public function slider(){
      $this->emit('init-range-slider');
    }

    public function aceptar(){
        // $this->validate();
        // $this->entrada->save();
        // $this->emit('ok', 'Inventario guardado correctamente');
    }

}
