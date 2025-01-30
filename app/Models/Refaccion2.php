<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refaccion2 extends Model
{
    use SoftDeletes;
    
    protected $table = 'refacciones2';

    protected $fillable = [
        'numero_reporte',
        'numero_parte',
        'descripcion',
        'proveedor_id',
        'estado',
        'condicion',
        'fecha_promesa',
        'fecha_recepcion',
        'ubicacion',
        'notas',
        'costo',
        'precio'
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function getFechaPromesaFormatAttribute(){
        $date = Carbon::parse($this->fecha_promesa);
        $format = 'M/d/Y';
        return $date->format($format);
    }

    public function getFechaRecepcionFormatAttribute(){
        if(!$this->fecha_recepcion){
            return 'PENDIENTE';
        }
        $date = Carbon::parse($this->fecha_recepcion);
        $format = 'M/d/Y h:i A';
        return $date->format($format);
    }

    public function getNombreProveedorAttribute(){
        if(!$this->proveedor){
            return 'SIN PROVEEDOR';
        }
        return $this->proveedor->nombre;
    }

    public function getNoReporteFormatAttribute(){
        return $this->numero_reporte ? $this->numero_reporte : 'N/A';
    }

    public function getNoParteAttribute(){
        return $this->numero_parte ? $this->numero_parte : 'N/A';
    }

    public function setNumeroParteAttribute($value){
        $this->attributes['numero_parte'] = trim(strtoupper($value));
    }

    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = trim(strtoupper($value));
    }

    // public function getRecibidoPorAttribute(){
    //     if(!$this->fecha_recepcion){
    //         return 'PENDIENTE';
    //     }
    //     return $this->logs->where('action', 'Receive')->first()->user->name;
    // }

    // public function registros_factura(){
    //     return $this->morphMany(RegistroFactura::class, 'model');
    // }

}
