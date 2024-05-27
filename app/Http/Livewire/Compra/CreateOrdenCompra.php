<?php

namespace App\Http\Livewire\Compra;

use App\Models\OrdenCompra;
use App\Models\OrdenCompraConcepto;
use App\Models\SolicitudCompra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateOrdenCompra extends Component
{
    public OrdenCompra $po;
    public $conceptos;


    protected $listeners = [
        'setProyecto' => 'setProyecto',
        'setSolicitudes' => 'setSolicitudes',
        'setProvider' => 'setProvider',
        'createPO' => 'createPO',
    ];

    protected $rules = [
        'po.nombre' => 'string',
        'po.estatus' => 'string',
        'po.tasa_iva' => 'numeric',
        'po.notas' => 'string',
        'po.emergente' => 'boolean',
        'conceptos.*.numero_parte' => 'string|required',
        'conceptos.*.descripcion' => 'string',
        'conceptos.*.cantidad' => 'numeric',
        'conceptos.*.precio' => 'numeric',
    ];

    public function mount(){
        $this->resetInput();
        $this->conceptos = $this->po->conceptos;
    }

    public function updated($name){
        if(str_starts_with($name, 'conceptos')){
            foreach ($this->po->conceptos as $key => $value) {
                $value->numero_parte = $this->conceptos[$key]->numero_parte;
                $value->descripcion = $this->conceptos[$key]->descripcion;
                $value->cantidad = $this->conceptos[$key]->cantidad;
                $value->precio = $this->conceptos[$key]->precio;
                $value->save();
            }
        }
    }

    public function resetInput(){
        $po = OrdenCompra::where(['user_id' => Auth::user()->id, 'estatus' => 'EN PROCESO'])->first();
        if($po == null){
            $this->po = new OrdenCompra([
                'nombre' => 'PENDIENTE',
                'estatus' => 'EN PROCESO',
                'tasa_iva' => 16.00,
                'emergente' => false,
            ]);
        }
        else{
            $this->po = $po;
        }
        $this->emit('$refresh');
    }

    public function render()
    {
        return view('livewire.compra.create-orden-compra.view');
    }

    public function save(){
        $this->po->save();
        $this->po->load('conceptos');
    }

    public function setProyecto($id){
        $this->po->proyecto_id = $id;
        $this->po->save();
    }

    public function setSolicitudes($ids){
        $this->po->emergente = false;
        foreach ($ids as $key => $value) {
            $sc = SolicitudCompra::findOrFail($key);

            foreach ($sc->conceptos as $item) {

                $contains = $this->po->conceptos->contains(function($elem) use ($item){
                    return $elem->solicitud_compra_conceptos->contains('id', $item->id);
                });

                if($contains){
                    return;
                }

                $po_con = $this->po->conceptos->where('numero_parte', $item->numero_parte)->where('descripcion', $item->descripcion)->first();
                $po_con = $po_con ?? collect([]);

                if($po_con->count() > 0){
                    $po_con = $this->po->conceptos->where('numero_parte', $item->numero_parte)->where('descripcion', $item->descripcion)->first();
                    $po_con->cantidad += $item->cantidad_solicitada;
                    $po_con->save();
                }
                else
                {
                    $po_con = OrdenCompraConcepto::create([
                        'orden_compra_id' => $this->po->id,
                        'presupuesto_material_id' => $item->presupuesto_material_id,
                        'numero_parte' => $item->numero_parte,
                        'descripcion' => $item->descripcion,
                        'unidad_venta' => $item->unidad_venta,
                        'cantidad' => $item->cantidad_solicitada,
                        'precio' => 3,
                        'entregado' => false,
                    ]);

                    $this->po->conceptos->push($po_con);
                }

                DB::insert('INSERT INTO orden_compra_concepto_solicitud_compra_concepto (solicitud_concepto_id, compra_concepto_id) VALUES (?, ?)', [$item->id, $po_con->id]);

            }
        }

        $this->conceptos = $this->po->conceptos;

    }

    public function setProvider($id){
        $this->po->proveedor_id = $id;
        $this->po->save();
        $this->po->load('proveedor');
    }

    public function addConcepto(){
        $this->po->emergente = true;
        $po_con = OrdenCompraConcepto::create([
            'orden_compra_id' => $this->po->id,
            'numero_parte' => "",
            'descripcion' => "[Descripción]",
            'unidad_venta' => 'PZ',
            'cantidad' => 1,
            'precio' => 0,
        ]);
        $this->po->save();
        $this->po->conceptos->push($po_con);
        $this->conceptos = $this->po->conceptos;
    }

    public function removeConcepto($id){
        $elem = OrdenCompraConcepto::FindOrFail($id);
        DB::table('orden_compra_concepto_solicitud_compra_concepto')->where('compra_concepto_id', $elem->id)->delete();
        $elem->delete();
        $this->po->load('conceptos');

    }

    public function createPO(){
        $this->validate([
            'conceptos.*.numero_parte' => 'string|required',
        ]);

        $this->po->nombre = $this->po->generateName();
        $this->po->estatus = 'PENDIENTE AUTORIZAR';
        if($this->po->save()){
            $this->emit('ok', "Se ha generado Orden de Compra");
            $this->resetInput();
        }
    }

    public function cancelPO(){
        foreach($this->po->conceptos as $item){
            foreach ($item->solicitud_compra_conceptos as $elem) {
                DB::delete('delete from orden_compra_concepto_solicitud_compra_concepto where compra_concepto_id = ?', [$elem->pivot->compra_concepto_id]);
            }
            $item->delete();
        }
        $this->po->delete();
        $this->resetInput();
    }
}
