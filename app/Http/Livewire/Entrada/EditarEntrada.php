<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Aseguradora;
use App\Models\Cliente;
use App\Models\Entrada;
use App\Models\Fabricante;
use App\Models\Sucursal;
use Livewire\Component;

class EditarEntrada extends Component
{
    public $cliente;
    public Entrada $entrada;

    protected $listeners = [
        'setCliente',
    ];

    protected $rules = [
        'cliente.nombre' => 'string',

        'entrada.sucursal_id' => 'numeric|required|min:1',
        'entrada.aseguradora_id' => 'numeric|required|min:1',
        'entrada.fabricante_id' => 'numeric|required|min:1',
        'entrada.cliente_id' => 'numeric|required|min:1',
        'entrada.origen' => 'string',
        'entrada.modelo' => 'string',
        'entrada.serie' => 'string|nullable',
        'entrada.orden' => 'string|nullable',
        'entrada.numero_factura' => 'string|nullable',
        'entrada.notas' => 'string|nullable',
        'entrada.razon_social' => 'string|max:255|nullable',
        'entrada.rfc' => 'string|max:255|nullable',
        'entrada.domicilio_fiscal' => 'string|max:255|nullable',
    ];

    public function mount(Entrada $entrada){
        $this->entrada = $entrada;
        $this->cliente = $entrada->cliente;
    }

    public function render()
    {
        return view('livewire.entrada.editar-entrada.view', $this->getRenderData());
    }
    
    public function getRenderData(){
        return [
            'sucursales' => Sucursal::allActive(),
            'aseguradoras' => Aseguradora::OrderBy('nombre')->get(),
            'fabricantes' => Fabricante::OrderBy('nombre')->get(),
        ];
    }

    public function setCliente($id){
        $this->cliente = $id > 0 ? Cliente::findOrFail($id) : null;
        $this->entrada->cliente_id = $this->cliente->id ?? 0;
    }

    public function edit(){
        $this->validate();
        if($this->entrada->save()){

            $this->emit('ok', 'Se ha editado entrada');
            $id = $this->entrada->id;
            return redirect()->to("/servicios/{$id}");
        }
    }
}
