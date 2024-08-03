<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Models\Pedido;
use App\Models\PedidoConcepto;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CatalogoPedidos extends LivewireBaseCrudController
{
    protected $model_name = "Pedido";
    protected $model_name_plural = "Pedidos";

    public $maxYear;
    public $year;
    public $weekStart;
    public $weekEnd;

    public $providerIdCombo;
    public $providerId;
    public $dataSum;

    public $selectedPedido;

    protected $queryString = ['year', 'weekStart', 'weekEnd'];

    protected $listeners = [
        'updateCatalogoPedidos',
        'send' => 'sendMail',
    ];

    protected $rules = [
        'selectedPedido.pagado' => 'required|date',
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

    public function totalProvider($id){
        $prov = $this->dataSum->where('proveedor_id', $id)->first();
        return $prov?->total ?? 0;
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

        $this->dataSum = PedidoConcepto::whereHas('pedido', function($q) use($dates) {
            $q->whereBetween('created_at', $dates);
        })->selectRaw('pedidos.proveedor_id, SUM(precio * cantidad) as total')
          ->join('pedidos', 'pedido_conceptos.pedido_id', '=', 'pedidos.id')
          ->groupBy('pedidos.proveedor_id')
          ->get();

        return [
            'data' => $data->paginate(50),
            'totalProveedores' => $totalProveedores,
            'proveedores' => Proveedor::all(),
            // 'dataSum' => $dataSum,
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

    public function mdlPago($id){
        $this->resetValidation();
        $this->selectedPedido = Pedido::findOrFail($id);
        if($this->selectedPedido?->pagado){
            $this->emit('showModal', '#mdlFechaPago');
        }
        else{
            Pedido::where('id', $id)->update(['pagado' => Db::raw('now()')]);
            $this->emit('ok', 'Pago registrado');
        }
    }

    public function removeDate(){
        $id = $this->selectedPedido->id;
        Pedido::where('id', $id)->update(['pagado' => null]);
        $this->emit('ok', 'Pago eliminado');
        $this->emit('closeModal', '#mdlFechaPago');
    }

    public function saveDate()
    {
        $this->validate([
            'selectedPedido.pagado' => 'date|required',
        ]);

        $id = $this->selectedPedido->id;
        Pedido::where('id', $id)->update(['pagado' => $this->selectedPedido->pagado]);
        $this->emit('ok', 'Pago actualizado');
        $this->emit('closeModal', '#mdlFechaPago');
    }

    public function mdlProviders($id){
        $this->selectedPedido = Pedido::findOrFail($id);
        $this->emit('showModal', '#mdlProviders');
    }

    public function setProvider(){
        $this->validate([
            'providerIdCombo' => 'numeric|min:1',
        ]);
        
        Pedido::where('id', $this->selectedPedido->id)->update(['proveedor_id' => $this->providerIdCombo]);
        $this->emit('ok', 'Proveedor actualizado');
        $this->emit('closeModal', '#mdlProviders');
    }
}
