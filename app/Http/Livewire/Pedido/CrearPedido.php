<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Controllers\PedidoController;
use App\Http\Traits\EmailValidateTrait;
use App\Models\Entrada;
use App\Models\Material;
use App\Models\Pedido;
use App\Models\PedidoConcepto;
use App\Models\PedidoConceptoTemp;
use App\Models\PedidoTemp;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearPedido extends Component
{
    use EmailValidateTrait;

    public $pedido_t;
    public $selectedConcepto;
    public $selectedEntrada = null;
    public $sendEmail = false;
    public $inputEmails;
    public $inputMessage;

    public $materialManual = [
        'descripcion' => null,
        'cantidad' => null,
        'precio' => null,
        'entrada_folio' => null,
    ];

    protected $listeners = [
        'setProveedor' => 'setProveedor',
        'setMaterial',
        'changeQty' => 'changeQty',
        'destroy',
        'limpiarPedido',
    ];

    protected $rules = [
        'pedido_t.conceptos.*.precio' => 'numeric|required',
        'pedido_t.comentarios' => 'string|nullable|max:255',

        'materialManual.descripcion' => 'string|required|max:255',
        'materialManual.cantidad' => 'numeric|required|min:0',
        'materialManual.precio' => 'numeric|required|min:0',
        'materialManual.entrada_folio' => 'string|required|min:5',
    ];

    public function updated($name, $value){
        if(str_starts_with($name,'pedido_t.comentarios')){
            $this->pedido_t->save();
        }
    }

    public function priceChange($index){
        $this->pedido_t->conceptos[$index]->save();
    }

    public function mount(){
        $this->cargarPedido();
    }

    public function render(){
        return view('livewire.pedido.crear-pedido.view');
    }

    public function cargarPedido(){
        $this->pedido_t = PedidoTemp::where(['usuario_id' => Auth::user()->id, 'sucursal_id' => Auth::user()->sucursal_default])->first();
        if ($this->pedido_t == null) {
            $this->pedido_t = PedidoTemp::create([
                'usuario_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursal_default,
            ]);
        }
    }

    public function limpiarPedido(){
        foreach ($this->pedido_t->conceptos as $concepto) {
            $concepto->delete();
        }
        $this->pedido_t->delete();
        $this->cargarPedido();
    }

    public function setProveedor($id){
        if ($id == 0) {
            $this->pedido_t->proveedor_id = null;
            $this->pedido_t->save();
        } else {
            $this->pedido_t->proveedor_id = $id;
            $this->pedido_t->save();
        }
        $this->pedido_t->refresh();
    }

    public function showMdlMateriales()
    {
        // $this->resetValidation();
        // $this->refaccion = new Refaccion();
        $this->emit('showModal', '#mdlCatalogoMateriales');
    }

    public function showMdlMaterialManual()
    {
        $this->emit('showModal', '#mdlMaterialManual');
    }

    public function createMaterialManual(){
        $this->validate([
            'materialManual.descripcion' => 'string|required|max:255',
            'materialManual.cantidad' => 'numeric|required|min:0',
            'materialManual.precio' => 'numeric|required|min:0',
            'materialManual.entrada_folio' => 'string|required|min:5',
        ]);

        if(!$this->selectedEntrada){
            $this->emit('info', 'No se ha seleccionado entrada');
            return;
        }

        $this->addMaterialManual(
            $this->materialManual['entrada_folio'], 
            $this->materialManual['descripcion'], 
            $this->materialManual['precio'], 
            $this->materialManual['cantidad'],
            $this->selectedEntrada->id,
        );
        $this->materialManual = [
            'descripcion' => null,
            'cantidad' => null,
            'precio' => null,
            'entrada_folio' => null,
        ];
        $this->selectedEntrada = null;
        $this->emit('closeModal', '#mdlMaterialManual');
    }


    public function addMaterialManual($codigo, $descripcion, $precio, $qty, $entrada_id){
        PedidoConceptoTemp::create([
            'pedido_temp_id' => $this->pedido_t->id,
            'material_id' => null,
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'cantidad' => $qty,
            'precio' => $precio,
            'entrada_id' => $entrada_id,
        ]);
        $this->pedido_t->load('conceptos');
    }

    public function setMaterial($id, $qty){
        $material = Material::findOrFail($id);
        PedidoConceptoTemp::create([
            'pedido_temp_id' => $this->pedido_t->id,
            'material_id' => $material->id,
            'codigo' => $material->numero_parte,
            'descripcion' => $material->descripcion,
            'cantidad' => $qty,
            'precio' => $material->precio,
        ]);
        $this->pedido_t->load('conceptos');
    }

    public function mdlChangeQty($id){
        $this->selectedConcepto = PedidoConceptoTemp::findOrFail($id);
        $this->emit('initMdlSelectQty', $this->selectedConcepto->cantidad);
    }

    public function changeQty($qty){
        if (($this->selectedConcepto->cantidad + $qty) < 1) {
            return;
        }
        $this->selectedConcepto->cantidad = $qty;
        $this->selectedConcepto->save();
        $this->pedido_t->load('conceptos');
    }

    public function addQty($id_reg, $qty){
        $ob = PedidoConceptoTemp::findOrFail($id_reg);
        if (($ob->cantidad + $qty) < 1) {
            return;
        }
        $ob->cantidad += $qty;
        $ob->save();
        $this->pedido_t->load('conceptos');
    }

    public function saveComment(){
        $this->pedido_t->save();
    }

    public function mdlEnviarPedido(){
        $this->inputEmails = $this->pedido_t->proveedor->correo;
        $this->inputMessage = "Se ha generado pedido para: " . $this->pedido_t->proveedor->nombre;
        $this->inputMessage .= "\n";
        $this->inputMessage .= "\n";
        $this->inputMessage .= "Saludos muchas gracias";
        return $this->emit('showModal', '#mdlEnviarPedido');
    }

    public function crearPedido(){

        if($this->sendEmail){
            $emailsArr = explode(",", $this->inputEmails);
            $emailsArr = array_filter($emailsArr, function($item){ 
                return $item;
            });
            $emailsArr = array_map(function($item){
                return trim($item);
            }, $emailsArr);
            foreach ($emailsArr as $mail) {
                if (!$this->is_valid_email($mail)) {
                    $this->emit('error', "Correo no válido: {$mail}");
                    return;
                }
            }
        }

        $pedido = Pedido::create([
            'proveedor_id' => $this->pedido_t->proveedor_id,
            'tasa_iva' => 0,
            'estatus'=> $this->sendEmail ? 'ENVIADO' : 'CREADO',
            'comentarios' => $this->pedido_t->comentarios,
        ]);

        if($pedido->save()){
            foreach ($this->pedido_t->conceptos as $item) {
                PedidoConcepto::create([
                    'pedido_id' => $pedido->id,
                    'material_id' => $item->material_id,
                    'codigo' => $item->codigo,
                    'descripcion' => $item->descripcion,
                    'cantidad' => $item->cantidad,
                    'cantidad_recibida' => 0,
                    'precio' => $item->precio,
                    'entrada_id' => $item->entrada_id,
                ]);
            }
        }

        if($this->sendEmail){
            try{
                PedidoController::enviarCorreo($pedido, $this->inputMessage, $emailsArr);
                $this->emit('ok', 'Se ha enviado pedido por correo');
            }
            catch(Exception $e){
                $error = $e->getMessage();
                preg_match("/\[(.*?)\]/", $error, $match);
                $this->emit('error', "Correo incorrecto: {$match[1]}", "No se pudo enviar correo");
                $this->emit('console', $e);
            }
        }else{
            $this->emit('ok', 'Se ha creado pedido');
        }
        $this->emit('closeModal', '#mdlEnviarPedido');
        $this->emit('limpiarPedido');
    }

    public function destroy($id)
    {
        $ob = PedidoConceptoTemp::find($id);
        if ($ob->delete()) {
            $this->emit('ok', 'Se ha eliminado Producto: ' . strtoupper($ob->descripcion));
        }
        $this->pedido_t->load('conceptos');
    }

    public function validateEntrada(){
        $this->selectedEntrada = null;

        $this->validate([
            'materialManual.entrada_folio' => 'string|required|min:5',
        ]);
        $this->selectedEntrada = Entrada::orderBy('id', 'desc')
        ->where('folio', 'LIKE', $this->materialManual['entrada_folio'] . '%')->first();

        if(!$this->selectedEntrada){
            $this->emit('info', 'No se encontró entrada con folio: ' . $this->materialManual['entrada_folio']);
        }

        
    }
}
