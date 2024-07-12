<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Models\Pedido;
use Carbon\Carbon;

class CatalogoPedidos extends LivewireBaseCrudController
{
    protected $model_name = "Pedido";
    protected $model_name_plural = "Pedidos";

    public $maxYear;
    public $year;
    public $weekStart;
    public $weekEnd;

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
        $dates = Entrada::getDateRange($this->year, $this->weekStart, $this->weekEnd);
        $this->emit('console', $dates); //TODO remove
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'DESC')
        ->whereBetween('created_at', $dates)
        ->paginate(100);
        return view('livewire.pedido.catalogo-pedidos.view', compact('data'));
    }

    public function mdlEnviarCorreo($id){
        $this->model = $this->model::findOrFail($id);
        $mail = $this->model->proveedor->correo;
        $mailBody = "Se ha generado pedido para: {$this->model->proveedor->nombre}";
        $mailBody .= "\n\nMas información en el documento adjunto";
        $this->emit('initMdlEnviarPedidoCorreo', $this->model, $mail, $mailBody);
    }
}
