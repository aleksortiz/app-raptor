<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Models\Pedido;
use App\Models\PedidoConcepto;
use App\Models\Proveedor;
use Carbon\Carbon;

class CatalogoPedidos extends LivewireBaseCrudController
{
    protected $model_name = "Pedido";
    protected $model_name_plural = "Pedidos";

    public $maxYear;
    public $year;
    public $weekStart;
    public $weekEnd;

    public $providerId;

    protected $queryString = ['year', 'weekStart', 'weekEnd'];

    protected $listeners = [
        'updateCatalogoPedidos',
        'send' => 'sendMail',
    ];
    
    public function mount(){
        Parent::mount();
        $this->weekStart = $this->weekStart ? $this->weekStart : Carbon::today()->weekOfYear;
        $this->weekEnd = $this->weekEnd ? $this->weekEnd : Carbon::today()->weekOfYear;
        $this->maxYear = $this->maxYear ? $this->maxYear : Carbon::today()->year;
        $this->year = $this->year ? $this->year : $this->maxYear;
    }

    public function updateCatalogoPedidos(){
        $this->render();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Pedido();
    }

    public function render()
    {
        return view('livewire.pedido.catalogo-pedidos.view', $this->getRenderData());
    }

    public function getRenderData(){
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'DESC')
        ->whereBetween('created_at', $dates);

        if($this->providerId){
            $data = $data->where('proveedor_id', $this->providerId);
        }

        $totalProveedores = PedidoConcepto::whereHas('pedido', function($q) use($dates) {
            $q->whereBetween('created_at', $dates);
        })->selectRaw('SUM(precio * cantidad) as total')->value('total');

        $dataSum = PedidoConcepto::whereHas('pedido', function($q) use($dates) {
            $q->whereBetween('created_at', $dates);
        })->selectRaw('pedidos.proveedor_id, SUM(precio * cantidad) as total')
          ->join('pedidos', 'pedido_conceptos.pedido_id', '=', 'pedidos.id')
          ->groupBy('pedidos.proveedor_id')
          ->get();

        return [
            'data' => $data->paginate(50),
            'totalProveedores' => $totalProveedores,
            'proveedores' => Proveedor::all(),
            'dataSum' => $dataSum,
        ];
    }

    public function mdlEnviarCorreo($id){
        $this->model = $this->model::findOrFail($id);
        $mail = $this->model->proveedor->correo;
        $mailBody = "Se ha generado pedido para: {$this->model->proveedor->nombre}";
        $mailBody .= "\n\nMas información en el documento adjunto";
        $this->emit('initMdlEnviarPedidoCorreo', $this->model, $mail, $mailBody);
    }

    public function selectProvider($id){
        $this->providerId = $id;
    }
}
