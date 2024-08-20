<?php

namespace App\Models;

use App\Models\shared\BaseModel;

class Refaccion extends BaseModel
{
    protected $table = 'refacciones';

    protected $fillable = [
        'model_id',
        'model_type',
        'usuario_id',
        'proveedor_id',
        'numero_parte',
        'descripcion',
        'cantidad',
        'costo',
        'precio',
    ];

    protected $attributes = [
        'numero_parte' => '',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->numero_parte = $model->numero_parte ? $model->numero_parte : "N/A";
        });
    }

    public function model(){
        return $this->morphTo();
    }

    public function getCostoTotalAttribute(){
        return $this->costo * $this->cantidad;
    }

    public function getUtilidadAttribute(){
        return $this->importe - $this->costo_total;
    }

    public function getImporteAttribute(){
        if($this->model->venta_refacciones){
            return $this->precio * $this->cantidad;
        }
        return $this->costo_total;
    }

    public function setNumeroParteAttribute($value){
        $this->attributes['numero_parte'] = strtoupper($value);
    }

    public function getComisionAttribute(){
        return $this->utilidad * 0.1;
    }
}
