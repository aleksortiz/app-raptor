<?php

namespace App\Http\Livewire\Vehiculo\Traits;

use App\Mail\ContratoCompraVentaMail;
use Illuminate\Support\Facades\Mail;

trait CreateContratoTrait
{
    public $contratoVendedor = 'GUILLERMO VILLANUEVA GUTIERREZ';
    public $contratoComprador;
    public $contratoDomicilioComprador;
    public $contratoFecha;
    public $contratoLugar = 'CD. JUAREZ, CHIHUAHUA';
    public $contratoPrecio;
    public $contratoPlazos;
    public $contratoAnticipo;
    public $contratoKilometraje;
    public $contratoIdentificacion = 'INE';
    public $contratoIdentificacionNumero;

    public $contratoSendMail = false;
    public $contratoMail;


    public function createContrato(){

        $this->validate([
            'contratoVendedor' => 'required|max:150',
            'contratoComprador' => 'required|max:150',
            'contratoDomicilioComprador' => 'required|max:255',
            'contratoFecha' => 'required|date',
            'contratoLugar' => 'required|max:150',
            'contratoPrecio' => 'required|numeric',
            'contratoPlazos' => 'required|numeric',
            'contratoAnticipo' => 'required|numeric',
            'contratoKilometraje' => 'required|numeric',
            'contratoIdentificacionNumero' => 'required|max:40',
        ]);

        $data = [
            'vendedor' => $this->contratoVendedor,
            'comprador' => $this->contratoComprador,
            'domicilioComprador' => $this->contratoDomicilioComprador,
            'fecha' => $this->contratoFecha,
            'lugar' => $this->contratoLugar,
            'precio' => $this->contratoPrecio,
            'plazos' => $this->contratoPlazos,
            'anticipo' => $this->contratoAnticipo,
            'kilometraje' => $this->contratoKilometraje,
            'identificacion' => $this->contratoIdentificacion,
            'noIdentificacion' => $this->contratoIdentificacionNumero,
            'idVehiculo' => $this->vehiculo->id,
        ];

        if($this->contratoSendMail){
            $mail = new ContratoCompraVentaMail($data);
            $addres = explode(',', $this->contratoMail);
            $addres = array_map('trim', $addres);
            Mail::to($addres)->queue($mail);
        }

        $this->emit('redirect', '/vehiculos/contrato-compra-venta?' . http_build_query($data));
        
    }

}