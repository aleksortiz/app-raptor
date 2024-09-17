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

    public $createMode = false;

    public $costos = [['concepto' => 'MANO DE OBRA', 'costo' => 0]];
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
        'entrada.rfc' => 'string|nullable|max:255',
        'entrada.razon_social' => 'string|nullable|max:255',
        'entrada.domicilio_fiscal' => 'string|nullable|max:255',
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
        $this->costos = [['concepto' => 'MANO DE OBRA', 'costo' => 0]];
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
        $this->entrada->rfc = $this->cliente->rfc ?? null;
        $this->entrada->razon_social = $this->cliente->razon_social ?? null;
        $this->entrada->domicilio_fiscal = $this->cliente->codigo_postal ?? null;
    }

    public function create(){
        $this->validate();
        $this->entrada->user_id = Auth::user()->id;
        if($this->entrada->save()){

            foreach ($this->costos as $costo) {
                $concepto = trim(strtoupper($costo['concepto']));
                $isManoDeObra = in_array($concepto, ['MANO DE OBRA', 'MO', 'MANO OBRA']);
                $tipo = $costo['concepto'] == $isManoDeObra ? 'MANO DE OBRA' : 'SERVICIO';
                Costo::create([
                    'model_id' => $this->entrada->id,
                    'model_type' => Entrada::class,
                    'concepto' => trim($costo['concepto']),
                    'venta' => $costo['costo'],
                    'costo' => 0,
                    'tipo' => $tipo,
                ]);
            }

            // foreach ($this->refacciones as $refaccion) {
            //     Refaccion::create([
            //         'entrada_id' => $this->entrada->id,
            //         'usuario_id' => $this->entrada->user_id,
            //         'model_id' => $this->entrada->id,
            //         'model_type' => Entrada::class,
            //         'refaccion' => $refaccion['refaccion'],
            //         'cantidad' => $refaccion['cantidad'],
            //         'precio' => $refaccion['precio'],
            //     ]);
            // }


            $this->emit('ok', 'Se ha creado entrada');
            $id = $this->entrada->id;
            $this->resetInput();
            $this->resetValidation();

            if(!$this->createMode){
              return redirect()->to("/servicios/{$id}?activeTab=2");
            }
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
