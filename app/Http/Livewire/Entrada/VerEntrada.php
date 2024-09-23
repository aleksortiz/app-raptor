<?php

namespace App\Http\Livewire\Entrada;

use App\Http\Traits\PhotoTrait;
use App\Models\Costo;
use App\Models\Entrada;
use App\Models\EntradaGasto;
use App\Models\EntradaMaterial;
use App\Models\Foto;
use App\Models\Material;
use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoPago;
use App\Models\PedidoConcepto;
use App\Models\Refaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
// use Intervention\Image\Facades\Image as InterventionImage;
use Livewire\WithFileUploads;

class VerEntrada extends Component
{
    use PhotoTrait, WithFileUploads;

    public $activeTab = 2;
    public Entrada $entrada;
    public $refaccion;

    public $tipo_fecha;
    public $fecha;

    public $costo;
    public $image;

    public $location_url = 'https://raptorv2.s3.amazonaws.com';
    public $storage_path = 'entradas/fotos';

    public $selectedWorkOrder = null;
    public $pagoDestajo = null;

    public $gastoConcepto;
    public $gastoMonto;

    public $lastUrl;

    public $materialManual = [
        'descripcion' => null,
        'cantidad' => null,
        'precio' => null,
    ];

    protected $listeners = [
        'destroyCosto',
        'destroyRefaccion',
        'removePhoto',
        'setMaterial',
        'destroyMaterial',
        'reload',
        'removeOrdenPago',
    ];

    protected $queryString = ['activeTab'];

    public function updatedEntradaPagoRefacciones(){

        $this->entrada->update([
            'pago_refacciones' => $this->entrada->pago_refacciones ? 1 : 0,
        ]);

        if($this->entrada->pago_refacciones){
            $this->emit('ok', 'Refacciones pagadas');
        }
    }

    public function getPorcentajeMoProperty(){
        return $this->entrada->origen == 'PARTICULAR' ? 30 : 30;
    }

    public function getPresupuestoDestajosProperty(){
      try {
        $costo = $this->costo?->venta;
        $costo = $costo ? $costo : 0;
        $porcentaje = $this->porcentaje_mo;
        return $costo * ($porcentaje / 100);
      } catch (\Throwable $th) {
        return 0;
      }

    }

    protected $rules = [
        'refaccion.descripcion' => 'string|required|max:255',
        'refaccion.numero_parte' => 'string|nullable|max:255',
        'refaccion.cantidad' => 'numeric|required|min:0',
        'refaccion.costo' => 'numeric|required|min:0',
        'refaccion.precio' => 'numeric|required|min:0',

        'costo.concepto' => 'string|required|max:255',
        'costo.costo' => 'numeric|required|min:0',
        'costo.venta' => 'numeric|required|min:0',
        'costo.no_factura' => 'string|nullable|max:255',
        'costo.tipo' => 'string|nullable|max:255',
        'costo.pagado' => 'date|nullable',

        'entrada.venta_refacciones' => 'boolean|required',

        'pagoDestajo' => 'numeric|required|min:0',

        'materialManual.descripcion' => 'string|required|max:255',
        'materialManual.cantidad' => 'numeric|required|min:0',
        'materialManual.precio' => 'numeric|required|min:0',
    ];

    public function reload(){
        $this->entrada->refresh();
    }

    public function mount(Entrada $entrada)
    {
        $this->lastUrl = url()->previous();
        $this->entrada = $entrada;

    }

    public function render()
    {
        return view('livewire.entrada.ver-entrada.view');
    }

    public function getFechaTituloProperty()
    {
        if ($this->tipo_fecha == 'fecha_entrega') {
            return 'Fecha de entrega';
        }
        else if ($this->tipo_fecha == 'fecha_pago') {
            return 'Fecha de pago';
        }
        else if ($this->tipo_fecha == 'fecha_pago_refacciones') {
            return 'Fecha pago de refacciones';
        }
    }

    public function showMdlRefacciones()
    {
        $this->resetValidation();
        $this->refaccion = new Refaccion();
        $this->emit('showModal', '#mdlCreateRefaccion');
    }

    public function createRefaccion()
    {
        // if (!$this->entrada->venta_refacciones) {
        //     $this->refaccion->precio = $this->refaccion->costo;
        // }

        $this->validate([
          'refaccion.numero_parte' => 'string|nullable|max:255',
        ]);
        // $this->refaccion->model_id = $this->entrada->id;
        // $this->refaccion->model_type = Entrada::class;
        // $this->refaccion->usuario_id = Auth::user()->id;
        if ($this->refaccion->save()) {
            $this->emit('ok', "Se ha guardado refacción: {$this->refaccion->descripcion}");
            $this->emit('closeModal', '#mdlCreateRefaccion');
            $this->entrada->load('refacciones');
            $this->entrada->load('costos');
            $this->refaccion = null;
        }
    }

    public function updatedEntradaVentaRefacciones(){
        $this->entrada->update([
            'venta_refacciones' => $this->entrada->venta_refacciones ? 1 : 0,
        ]);
        $this->entrada->refresh();
    }

    public function createMaterialManual(){
        $this->validate([
            'materialManual.descripcion' => 'string|required|max:255',
            'materialManual.cantidad' => 'numeric|required|min:0',
            'materialManual.precio' => 'numeric|required|min:0',
        ]);

        EntradaMaterial::create([
            'entrada_id' => $this->entrada->id,
            'material_id' => null,
            'cantidad' => $this->materialManual['cantidad'],
            'numero_parte' => "MANUAL",
            'material' => $this->materialManual['descripcion'],
            'unidad_medida' => 'pz',
            'precio' => $this->materialManual['precio'],
        ]);

        $this->entrada->load('materiales');
        $this->materialManual = [
            'descripcion' => null,
            'cantidad' => null,
            'precio' => null,
        ];
        $this->emit('ok', 'Se ha registrado material');
        $this->emit('closeModal', '#mdlMaterialManual');
    }

    public function destroyCosto($id)
    {
        $elem = Costo::findOrFail($id);
        $elem->refacciones->each(function($refaccion){
            $refaccion->delete();
        });
        if ($elem->delete()) {
            $this->emit('ok', "Se ha eliminado costo");
            $this->entrada->load('costos');
        }
    }

    public function destroyRefaccion($id)
    {
        $elem = Refaccion::findOrFail($id);
        if ($elem->delete()) {
            $this->emit('ok', "Se ha eliminado refacción");
            $this->entrada->load('refacciones');
        }
    }

    public function destroyMaterial($id)
    {
        $elem = EntradaMaterial::findOrFail($id);
        if ($elem->delete()) {
            $this->emit('ok', "Se ha eliminado material");
            Material::where('id', $elem->material_id)->increment('existencia', $elem->cantidad);
            $this->entrada->load('materiales');

            if($elem->pedido_concepto_id){
                $pedidoConcepto = PedidoConcepto::findOrFail($elem->pedido_concepto_id);
                $pedidoConcepto->cantidad_recibida -= $elem->cantidad;
                $pedidoConcepto->save();
            }
        }
    }


    public function addCosto()
    {
        $this->costo = new Costo();
        $count = $this->entrada->costos->count();
        $count++;
        $this->costo->concepto = null;

        $this->resetValidation();
        $this->emit('showModal', '#mdlCreateCosto');
    }

    public function removeCosto()
    {
        $this->costo = null;
    }

    public function editCosto($id)
    {
        $this->costo = Costo::findOrFail($id);
    }

    public function saveCosto()
    {
        $this->validate([
            'costo.concepto' => 'string|required|max:255',
            'costo.costo' => 'numeric|required|min:0',
            'costo.venta' => 'numeric|required|min:0',
            'costo.tipo' => 'string|required',
        ]);

        if($this->costo->tipo == 'SERVICIO' || $this->costo->tipo == 'MANO DE OBRA'){
            $this->costo->costo = 0;
        }



        $this->costo->model_id = $this->entrada->id;
        $this->costo->model_type = Entrada::class;
        if ($this->costo->save()) {

          if($this->costo->tipo == 'REFACCION'){
            if($this->costo->refacciones->count() == 0){
              Refaccion::create([
                'model_id' => $this->costo->id,
                'model_type' => Costo::class,
                'descripcion' => $this->costo->concepto,
                'cantidad' => 1,
                'costo' => $this->costo->costo,
                'precio' => $this->costo->venta,
                'usuario_id' => Auth::user()->id,
              ]);
            }
            else{
              $this->costo->refacciones->each(function($refaccion){
                $refaccion->update([
                  'descripcion' => $this->costo->concepto,
                  'costo' => $this->costo->costo,
                  'precio' => $this->costo->venta,
                ]);
              });
            }
          }
          else{
            $this->costo->refacciones->each(function($refaccion){
              $refaccion->delete();
            });
          }



          $this->entrada->load('costos');
          $this->costo = null;
        }
        $this->emit('ok', 'Se ha guardado costo');
        $this->emit('closeModal', '#mdlCreateCosto');
    }

    public function updatedImage()
    {
        $this->upload();
    }

    public function upload()
    {

        $this->validate([
            'image' => 'image|max:10000',
        ]);

        $name = $this->image->store($this->storage_path, 'public');

        // $img = InterventionImage::make("storage/{$name}");
        // $img->resize(1200, null, function($constraint){
        //     $constraint->aspectRatio();
        //     $constraint->upsize();
        // });
        // $img->save();

        $resizedImage = Storage::disk('public')->get($name);

        if (Storage::disk('s3')->put($name, $resizedImage)) {
            Storage::disk('public')->delete($name);
            if ($name) {
                $foto = Foto::create([
                    'model_id' => $this->entrada->id,
                    'model_type' => Entrada::class,
                    'url' => $name,
                ]);
                $this->emit('ok', 'Se ha subido foto');
                $this->entrada->fotos->push($foto);
            }
        }
    }

    public function removePhoto($id)
    {

        $foto = Foto::findOrFail($id);
        if (Storage::disk('s3')->exists($foto->url)) {
            Storage::disk('s3')->delete($foto->url);
            $this->emit('ok', 'Se ha eliminado foto', 'Foto eliminada');
        }

        $foto->delete();
        $this->entrada->load('fotos');
    }

    public function showMdlMateriales()
    {
        // $this->resetValidation();
        // $this->refaccion = new Refaccion();
        $this->emit('showModal', '#mdlCatalogoMateriales');
    }

    public function showMdlMaterialManual()
    {
        // $this->resetValidation();
        // $this->refaccion = new Refaccion();
        $this->emit('showModal', '#mdlMaterialManual');
    }

    public function setMaterial($id, $cantidad)
    {
        $material = Material::findOrFail($id);
        EntradaMaterial::create([
            'entrada_id' => $this->entrada->id,
            'material_id' => $material->id,
            'cantidad' => $cantidad,
            'numero_parte' => $material->numero_parte,
            'material' => $material->descripcion,
            'unidad_medida' => $material->unidad_medida,
            'precio' => $material->precio,
        ]);

        Material::where('id', $material->id)->decrement('existencia', $cantidad);
        $this->entrada->load('materiales');
    }

    public function entregarVehiculo()
    {
        $this->entrada->update([
            'fecha_entrega' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha entregado vehículo');
    }

    public function pagarEntrada()
    {
        $this->entrada->update([
            'fecha_pago' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha pagado entrada');
    }

    public function pagarServicio($costo_id)
    {
        $costo = Costo::findOrFail($costo_id);
        $costo->update([
            'pagado' => DB::raw('now()'),
        ]);
        $this->entrada->load('costos');
        $this->emit('ok', 'Se ha pagado servicio: ' . $costo->concepto);
    }

    public function eliminarPagoServicio($id){
        $costo = Costo::findOrFail($id);
        $costo->update([
            'pagado' => null,
        ]);
        $this->entrada->load('costos');
        $this->removeCosto();
        $this->emit('ok', 'Se ha eliminado pago de servicio: ' . $costo->concepto);
    }

    public function pagarRefacciones()
    {
        $this->entrada->update([
            'fecha_pago_refacciones' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se han pagado refacciones');
    }

    public function editFechaEntrega()
    {
        $this->tipo_fecha = 'fecha_entrega';
        $this->fecha = $this->entrada->fecha_entrega;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function editFechaPagoRefacciones()
    {
        $this->tipo_fecha = 'fecha_pago_refacciones';
        $this->fecha = $this->entrada->fecha_pago_refacciones;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function editFechaPago()
    {
        $this->tipo_fecha = 'fecha_pago';
        $this->fecha = $this->entrada->fecha_pago;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function removeDate()
    {
        $this->entrada->update([
            $this->tipo_fecha => null,
        ]);
        $this->emit('closeModal', '#mdlEditDate');
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha eliminado fecha');
    }

    public function saveDate()
    {
        $this->validate([
            'fecha' => 'date|required',
        ]);

        $this->entrada->update([
            $this->tipo_fecha => $this->fecha,
        ]);
        $this->emit('closeModal', '#mdlEditDate');
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha actualizado fecha');
    }

    public function mdlEditarRefaccion($id)
    {
        $this->refaccion = Refaccion::findOrFail($id);
        $this->emit('showModal', '#mdlCreateRefaccion');
    }

    public function mdlCreateWorkOrder(){
        $this->emit('showModal', '#mdlCreateWorkOrder');
    }

    public function mdlRegistrarPagoDestajo($id){
        $this->selectedWorkOrder = OrdenTrabajo::findOrFail($id);
        $this->emit('showModal', '#mdlRegistrarPagoDestajo');
    }

    public function registrarPagoDestajo(){
        $pagoMax = $this->selectedWorkOrder->pendiente;
        $this->validate([
            'pagoDestajo' => "numeric|required|min:0|lte:{$pagoMax}",
        ]);
        OrdenTrabajoPago::create([
            'orden_trabajo_id' => $this->selectedWorkOrder->id,
            'monto' => $this->pagoDestajo,
        ]);
        $this->pagoDestajo = null;
        $this->entrada->load('ordenes_trabajo');
        $this->emit('ok', 'Se ha registrado pago de destajo');
        $this->emit('closeModal', '#mdlRegistrarPagoDestajo');
    }

    public function removeOrdenPago($id){
        $pago = OrdenTrabajoPago::findOrFail($id);
        if($pago->delete()){
            $this->selectedWorkOrder->load('pagos');
            $this->entrada->load('ordenes_trabajo');
            $this->emit('ok', 'Se ha eliminado pago de destajo');
        }
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }

    public function createGasto(){
      $this->validate([
        'gastoConcepto' => 'string|required|max:255',
        'gastoMonto' => 'numeric|required|min:0',
      ]);

      EntradaGasto::create([
        'entrada_id' => $this->entrada->id,
        'concepto' => $this->gastoConcepto,
        'monto' => $this->gastoMonto,
        'user_id' => Auth::id(),
      ]);

      $this->entrada->load('gastos');
      $this->gastoConcepto = null;
      $this->gastoMonto = null;
      $this->emit('ok', 'Se ha registrado gasto');
      $this->emit('closeModal', '#mdlCreateGasto');
    }
}
