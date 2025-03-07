<?php

namespace App\Http\Livewire\Vehiculo;

use App\Models\Vehiculo;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoVehiculos extends Component
{
    use WithPagination;

    public $marca;
    public $modelo;
    public $year;
    public $color;
    public $serie;
    public $placas;
    public $factura;
    public $pedimento;
    public $precio_venta;

    protected $rules = [
        'marca' => 'required',
        'modelo' => 'required',
        'year' => 'required',
        'color' => 'required',
        'serie' => 'nullable',
        'placas' => 'nullable',
        'factura' => 'nullable',
        'pedimento' => 'nullable',
        'precio_venta' => 'required',
    ];

    public function render()
    {
        return view('livewire.vehiculo.catalogo-vehiculos.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);

        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
            'vehiculos' => Vehiculo::paginate(50),
        ];
    }

    public function registrar()
    {
        $this->validate();

        Vehiculo::create([
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'year' => $this->year,
            'color' => $this->color,
            'serie' => $this->serie,
            'placas' => $this->placas,
            'factura' => $this->factura,
            'pedimento' => $this->pedimento,
            'precio_venta' => $this->precio_venta,
            'estado' => 'DISPONIBLE',
        ]);

        $this->reset([
            'marca',
            'modelo',
            'year',
            'color',
            'serie',
            'placas',
            'factura',
            'pedimento',
            'precio_venta',
        ]);

        $this->emit('closeModal', "#mdl");
        $this->emit('ok', "Se ha registrado vehículo");
    }


}
