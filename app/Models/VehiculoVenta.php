<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendedor',
        'vehiculo_id',
        'cliente_id',
        'comprador',
        'comprador_domicilio',
        'fecha',
        'lugar',
        'precio_venta',
        'plazos',
        'anticipo',
        'identificacion',
        'no_identificacion',
        'kilometraje',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
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
