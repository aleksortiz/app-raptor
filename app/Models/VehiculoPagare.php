<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiculoPagare extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'vehiculo_id',
        'numero_pagare',
        'monto',
        'fecha',
        'fecha_pago',
        'tasa_interes'
    ];

    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class);
    }

    public function getFechaPagareFormatAttribute(){
        return Carbon::parse($this->fecha)->format('m-d-Y');
    }

    public function getEstatusSpanAttribute()
    {
        if(!$this->fecha_pago) {
            return '<button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> Pendiente</button>';
        }
    }

    public function getFechaLetraAttribute(){
        $date = new DateTime($this->fecha);

        $meses = [
            "01" => "Enero", "02" => "Febrero", "03" => "Marzo",
            "04" => "Abril", "05" => "Mayo", "06" => "Junio",
            "07" => "Julio", "08" => "Agosto", "09" => "Septiembre",
            "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"
        ];

        $dia = $date->format("d");
        $mes = $meses[$date->format("m")];
        $anio = $date->format("Y");

        $fecha_formateada = "$dia de $mes de $anio";

        return $fecha_formateada;
    }
}
