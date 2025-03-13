<?php

namespace App\Http\Livewire;

use App\Models\Entrada;
use App\Models\Refaccion;
use App\Models\RegistroFactura;
use Illuminate\Support\Facades\DB;
// use App\Models\Venta;
use Livewire\Component;

class ControlFacturacion extends Component
{
    public $mdlName = 'mdlRegistroFactura';
    public $selected_id;
    public $selected_model;

    public $numero_factura;
    public $monto;
    public $notas;
    public $fecha_pago;
    
    public $search;


    protected $rules = [
        'numero_factura' => 'required',
        'monto' => 'required|numeric',
        'notas' => 'nullable',
        'fecha_pago' => 'nullable|date',
    ];

    public function render()
    {
        return view('livewire.control-facturacion.view', $this->getRenderData());
    }


    public function registrarFactura($id, $model){
        $this->selected_id = $id;
        $this->selected_model = $model;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function getRenderData()
    {
        $entradas = Entrada::orderBy('created_at', 'DESC')
        ->whereDoesntHave('registros_factura');
        $this->search = trim($this->search);

        if($this->search != ''){
            $entradas->where(function ($q){
                $q->orWhere('modelo', 'LIKE', "%{$this->search}%")
                ->orWhereHas('fabricante', function($fab){
                    $fab->where('nombre', 'LIKE', "%{$this->search}%");
                })
                ->orWhereHas('cliente', function($fab){
                    $fab->where('nombre', 'LIKE', "%{$this->search}%");
                })
                ->orWhere('folio', 'LIKE', "{$this->search}%")
                ->orWhere('serie', 'LIKE', "{$this->search}%")
                ->orWhere('orden', 'LIKE', "{$this->search}%")
                ->orWhere(DB::raw('REPLACE(orden, " ", "")'), 'LIKE', trim($this->search).'%');
            });
        }
        

        return [
            'entradas' => $entradas->get(),
            // 'refacciones' => $refacciones
        ];
    }

    public function registrar(){
        $this->validate();

        $model = null;
        if($this->selected_model == 'ENTRADA'){
            $model = Entrada::class;
        } else if($this->selected_model == 'REFACCION'){
            $model = Refaccion::class;
        }

        if(!$model){
            $this->emit('closeModal', "#{$this->mdlName}");
            $this->emit('error', 'No se encontró el modelo seleccionado');
            return;
        }

        $data = [
            'model_id' => $this->selected_id,
            'model_type' => $model,
            'numero_factura' => $this->numero_factura,
            'monto' => $this->monto,
            'notas' => $this->notas,
            'fecha_pago' => $this->fecha_pago ? $this->fecha_pago : null,
        ];

        RegistroFactura::create($data);

        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit('ok', 'Registro guardado');

        $this->reset();
    }
}
