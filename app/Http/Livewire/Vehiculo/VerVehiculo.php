<?php

namespace App\Http\Livewire\Vehiculo;

// use App\Http\Livewire\Vehiculo\Traits\CreateContratoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateGastoTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateParteTrait;
use App\Http\Livewire\Vehiculo\Traits\CreateVehiculoCuentaTrait;
use App\Mail\ContratoCompraVentaMail;
use App\Models\Cliente;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VerVehiculo extends Component
{
    use CreateGastoTrait, CreateParteTrait, CreateVehiculoCuentaTrait;

    public $tab;

    public $vehiculo;
    public $lastUrl;

    public $descripcionVenta;
    public $emailAddress;

    public $ventaVendedor = 'GUILLERMO VILLANUEVA GUTIERREZ';
    public $ventaClienteId;
    public $ventaClienteNombre;
    public $ventaCompradorDomicilio;
    public $ventaFecha;
    public $ventaLugar = 'CD. JUAREZ, CHIHUAHUA';
    public $ventaPrecioVenta;
    public $ventaAnticipo;
    public $ventaIdentificacion = 'INE';
    public $ventaNoIdentificacion;
    public $ventaKilometraje;
    public $ventaPlazos;
    public $ventaMail;

    public $ventaSendMail = false;
    
    protected $rules = [
        'vehiculo.gastos.*.descripcion' => 'required|string|max:255',
        'vehiculo.gastos.*.estimacion' => 'required|numeric',
        'vehiculo.gastos.*.monto' => 'required|numeric',
        'vehiculo.moneda' => 'required|string|max:3',
        'vehiculo.cotizacion_usd' => 'required|numeric',

        'vehiculo.marca' => 'required',
        'vehiculo.modelo' => 'required',
        'vehiculo.year' => 'required',
        'vehiculo.color' => 'required',
        'vehiculo.serie' => 'nullable',
        'vehiculo.placa' => 'nullable',
        'vehiculo.factura' => 'nullable',
        'vehiculo.pedimento' => 'nullable',
        'vehiculo.precio_venta' => 'required',
        'vehiculo.numero_lote' => 'nullable',
        'vehiculo.estado' => 'nullable',
    ];

    protected $listeners = [
        'deleteGasto',
        'deleteParte',
        'deleteVehiculoCuenta',
        'setCliente',
        'deleteVenta',
    ];

    protected $queryString = [
        'tab' => ['except' => ''],
    ];

    public function mount($id){
        $this->ventaFecha = now()->format('Y-m-d');
        $this->lastUrl = url()->previous();
        $this->vehiculo = Vehiculo::findOrFail($id);
        $this->descripcionVenta = $this->vehiculo->descripcion_venta;
    }

    public function render()
    {
        return view('livewire.vehiculo.ver-vehiculo.view', $this->getRenderData());
    }

    public function getRenderData(){
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);
        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
        ];
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }

    public function saveGastos(){
        $this->validate();

        foreach ($this->vehiculo->gastos as $gasto) {
            $gasto->save();
        }
        
        $this->emit('ok', 'Se han guardado gastos');
    }

    public function addGasto(){
        $this->vehiculo->gastos()->create([
            'fecha' => now(),
            'estimacion' => 0,
            'monto' => 0,
            'descripcion' => '',
        ]);

        // $this->gastos = $this->vehiculo->gastos;
        $this->vehiculo->load('gastos');
    }

    public function saveDescripcionVenta(){
        $this->vehiculo->descripcion_venta = $this->descripcionVenta;
        $this->vehiculo->save();
        $this->emit('ok', 'Se ha guardado la descripción de venta');
    }

    public function mdlSendMail(){
        $this->emit('showModal', '#mdlSendMail');
    }

    public function sendMail(){
        $this->validate([
            'emailAddress' => 'required',
        ]);

        $this->vehiculo->sendMail($this->emailAddress);
        $this->emit('ok', 'Correo enviado');
        $this->emit('closeModal', '#mdlSendMail');
        $this->reset('emailAddress');
    }

    public function saveData(){
        $this->validate([
            'vehiculo.marca' => 'required',
            'vehiculo.modelo' => 'required',
            'vehiculo.year' => 'required',
            'vehiculo.color' => 'required',
            'vehiculo.serie' => 'nullable',
            'vehiculo.placa' => 'nullable',
            'vehiculo.factura' => 'nullable',
            'vehiculo.pedimento' => 'nullable',
            'vehiculo.precio_venta' => 'required',
            'vehiculo.numero_lote' => 'nullable',
            'vehiculo.estado' => 'nullable',
        ]);

        $this->vehiculo->save();
        $this->emit('closeModal', '#mdlEdit');
        $this->emit('ok', 'Se han guardado los datos');
    }

    public function setCliente($id){
        if($id == 0){
            $this->ventaClienteId = null;
            $this->ventaClienteNombre = null;
            $this->ventaCompradorDomicilio = null;
            // $this->ventaMail = null;
            return;
        }
        $cliente = Cliente::findOrFail($id);
        $this->ventaClienteId = $cliente->id;
        $this->ventaClienteNombre = $cliente->nombre;
        $this->ventaCompradorDomicilio = $cliente->direccion;
        // $this->ventaMail = $cliente->correo;
    }

    public function createVenta(){

        $this->validate([
            'ventaVendedor' => 'required|max:200',
            'ventaClienteId' => 'numeric|required',
            'ventaClienteNombre' => 'required|max:200',
            'ventaCompradorDomicilio' => 'required|max:255',
            'ventaFecha' => 'required|date',
            'ventaLugar' => 'required|max:200',
            'ventaPrecioVenta' => 'required|numeric',
            'ventaAnticipo' => 'required|numeric|lt:ventaPrecioVenta',
            'ventaKilometraje' => 'nullable|numeric',
            'ventaIdentificacion' => 'nullable|max:40',
            'ventaNoIdentificacion' => 'required_with:ventaIdentificacion|max:40',
            'ventaPlazos' => 'required|numeric',
            'ventaMail' => 'nullable|string',
        ]);

        if(!$this->ventaKilometraje){
            $this->ventaKilometraje = "0";
        }
        if(!$this->ventaIdentificacion){
            $this->ventaIdentificacion = "";
        }
        if(!$this->ventaNoIdentificacion){
            $this->ventaNoIdentificacion = "";
        }

        $data = [
            'vendedor' => $this->ventaVendedor,
            'comprador' => $this->ventaClienteNombre,
            'domicilioComprador' => $this->ventaCompradorDomicilio,
            'fecha' => $this->ventaFecha,
            'lugar' => $this->ventaLugar,
            'precio' => $this->ventaPrecioVenta,
            'plazos' => $this->ventaAnticipo,
            'anticipo' => $this->ventaAnticipo,
            'kilometraje' => $this->ventaKilometraje,
            'identificacion' => $this->ventaIdentificacion,
            'noIdentificacion' => $this->ventaNoIdentificacion,
            'idVehiculo' => $this->vehiculo->id,
        ];

        $venta = $this->vehiculo->venta()->create([
            'vendedor' => $this->ventaVendedor,
            'cliente_id' => $this->ventaClienteId,
            'comprador' => $this->ventaClienteNombre,
            'comprador_domicilio' => $this->ventaCompradorDomicilio,
            'fecha' => $this->ventaFecha,
            'lugar' => $this->ventaLugar,
            'precio_venta' => $this->ventaPrecioVenta,
            'plazos' => $this->ventaPlazos,
            'anticipo' => $this->ventaAnticipo,
            'identificacion' => $this->ventaIdentificacion,
            'no_identificacion' => $this->ventaNoIdentificacion,
            'kilometraje' => $this->ventaKilometraje,
        ]);


        if($venta){
            if($this->ventaSendMail && $this->ventaMail){
                $mail = new ContratoCompraVentaMail($data);
                $addres = explode(',', $this->ventaMail);
                $addres = array_map('trim', $addres);
                Mail::to($addres)->queue($mail);
            }

            if($this->ventaPlazos > 0){
                $monto = $this->ventaPrecioVenta - $this->ventaAnticipo;
                $monto = $monto / $this->ventaPlazos;

                foreach (range(1, $this->ventaPlazos) as $i) {
                    $fecha = Carbon::parse($this->ventaFecha)->addMonths($i);
                    $this->vehiculo->pagares()->create([
                        'numero_pagare' => "$i de $this->ventaPlazos",
                        'monto' => $monto,
                        'fecha' => $fecha,
                        'tasa_interes' => 5,
                    ]);
                }
            }




            $this->emit('ok', 'Venta registrada');
            $this->vehiculo->estado = 'VENDIDO';
            $this->vehiculo->save();
            $this->vehiculo->load('venta');
    
            // $this->emit('redirect', '/vehiculos/contrato-compra-venta?' . http_build_query($data));

        }
        else{
            $this->emit('error', 'No se pudo crear la venta');
        }


        
    }

    public function verContrato(){
        $data = [
            'vendedor' => $this->vehiculo->venta->vendedor,
            'comprador' => $this->vehiculo->venta->comprador,
            'domicilioComprador' => $this->vehiculo->venta->comprador_domicilio,
            'fecha' => $this->vehiculo->venta->fecha,
            'lugar' => $this->vehiculo->venta->lugar,
            'precio' => $this->vehiculo->venta->precio_venta,
            'plazos' => $this->vehiculo->venta->plazos,
            'anticipo' => $this->vehiculo->venta->anticipo,
            'kilometraje' => $this->vehiculo->venta->kilometraje,
            'identificacion' => $this->vehiculo->venta->identificacion,
            'noIdentificacion' => $this->vehiculo->venta->no_identificacion,
            'idVehiculo' => $this->vehiculo->id,
        ];

        $this->emit('redirect', '/vehiculos/contrato-compra-venta?' . http_build_query($data));

    }

    public function deleteVenta(){
        $this->vehiculo->venta->delete();
        $this->vehiculo->pagares()->delete();
        $this->vehiculo->estado = 'DISPONIBLE';
        $this->vehiculo->save();
        $this->vehiculo->load('venta');
        $this->emit('ok', 'Venta eliminada');
    }


    //**TODO: notas agarre carros a cuenta
    //**TODO: clientes catalogo
    //TODO: agregaste carros a cuenta y senalar en contrato
    //**TODO: ver status de vehiculo
    //**TODO: Numero de Lote
    //TODO: Editar y Fecha de venta

}
