<?php

namespace App\Http\Livewire\Entrada;

use App\Models\CitaReparacion;
use App\Models\Cliente;
use App\Models\Fabricante;
use Livewire\Component;

class CrearCitaReparacion extends Component
{
    public $cliente_id;
    public $cliente_nombre;
    public $marca;
    public $modelo;
    public $no_reporte;
    public $cita;

    protected $listeners = [
      'setCliente'
    ];

    protected $rules = [
        'cliente_id' => 'numeric|required|exists:clientes,id',
        'marca' => 'required|string',
        'modelo' => 'required|string',
        'no_reporte' => 'required|string',
        'cita' => 'required|date',
    ];

    public function render()
    {
        return view('livewire.entrada.crear-cita-reparacion.view', $this->getRenderData());
    }

    public function getRenderData(){
      return [
          'fabricantes' => Fabricante::OrderBy('nombre')->get(),
      ];
    }

    public function setCliente($cliente_id)
    {
        $cliente = Cliente::findOrFail($cliente_id);
        $this->cliente_id = $cliente_id;
        $this->cliente_nombre = $cliente->nombre;
    }

    public function create(){
        $this->validate();

        CitaReparacion::create([
          'cliente_id' => $this->cliente_id,
          'marca' => $this->marca,
          'modelo' => $this->modelo,
          'no_reporte' => $this->no_reporte,
          'cita' => $this->cita,
        ]);

        $this->emit('ok', 'Se ha creado cita');
        return redirect()->to('/citas-reparacion');
    }



}
