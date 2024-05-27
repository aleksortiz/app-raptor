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

class CrearEntrada extends Component
{
    public $cliente;
    public $redirectMode;
    public Entrada $entrada;

    public $costos = [['concepto' => 'Carroceria', 'costo' => 0]];
    public $refacciones = [];


    protected $listeners = [
        'setCliente',
    ];

    protected $rules = [
        'cliente.nombre' => 'string',

        'entrada.sucursal_id' => 'numeric|required|min:1',
        'entrada.aseguradora_id' => 'numeric|required|min:1',
        'entrada.fabricante_id' => 'numeric|required|min:1',
        'entrada.cliente_id' => 'numeric|required|min:1',
        'entrada.origen' => 'string|max:255',
        'entrada.modelo' => 'string|max:255',
        'entrada.notas' => 'string|nullable|max:255',
        'entrada.serie' => 'string|nullable|max:255',
        'entrada.orden' => 'string|nullable|max:255',
        'entrada.numero_factura' => 'string|nullable|max:255',

        // 'costos' => 'array|required',
        'costos.*.concepto' => 'string|required|max:255',
        'costos.*.costo' => 'numeric|required|min:0',

        'refacciones.*.refaccion' => 'string|required|max:255',
        'refacciones.*.cantidad' => 'numeric|required|min:1',
        'refacciones.*.precio' => 'numeric|required|min:0',
    ];

    public function mount(){
        $this->entrada = new Entrada();
    }
    
    public function resetInput(){
        $this->entrada = new Entrada();
        $this->setCliente(0);
    }

    public function render(){
        return view('livewire.entrada.crear-entrada.view', $this->getRenderData());
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

    public function create(){
        $this->validate();
        $this->entrada->user_id = Auth::user()->id;
        if($this->entrada->save()){

            foreach ($this->costos as $costo) {
                Costo::create([
                    'model_id' => $this->entrada->id,
                    'model_type' => Entrada::class,
                    'concepto' => $costo['concepto'],
                    'costo' => $costo['costo'],
                ]);
            }

            foreach ($this->refacciones as $refaccion) {
                Refaccion::create([
                    'entrada_id' => $this->entrada->id,
                    'usuario_id' => $this->entrada->user_id,
                    'model_id' => $this->entrada->id,
                    'model_type' => Entrada::class,
                    'refaccion' => $refaccion['refaccion'],
                    'cantidad' => $refaccion['cantidad'],
                    'precio' => $refaccion['precio'],
                ]);
            }


            $this->emit('ok', 'Se ha creado entrada');
            $id = $this->entrada->id;
            $this->resetInput();
            // return redirect()->to("/servicios/{$id}/subir-fotos?redirectMode=true");
            return redirect()->to("/servicios/{$id}?activeTab=3");
        }
    }

    public function addCosto(){
        $count = count($this->costos);
        $count++;
        $costo = ['concepto' => "Venta {$count}", 'costo' => 0];
        array_push($this->costos, $costo);


        // $test = $count;
        // dd($test);

    }

    public function addRefaccion(){
        $refaccion = ['refaccion' => '', 'precio' => 0, 'cantidad' => 1];
        array_push($this->refacciones, $refaccion);
    }

    public function removeCosto($index){
        unset($this->costos[$index]);
        $this->costos = array_values($this->costos);
    }

    public function removeRefaccion($index){
        unset($this->refacciones[$index]);
        $this->refacciones = array_values($this->refacciones);
    }
}
