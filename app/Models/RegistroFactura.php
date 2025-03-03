<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;

class RegistroFactura extends BaseModel
{
    protected $table = 'registro_facturas';
    
    protected $fillable = [
        'model_id',
        'model_type',
        'numero_factura',
        'monto',
        'notas',
        'fecha_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'date'
    ];

    public function model(){
        return $this->morphTo();
    }

    public function setNumeroFacturaAttribute($value){
        $this->attributes['numero_factura'] = trim(strtoupper($value));
    }

    public function getPagadoAttribute(){
        return $this->fecha_pago ? true : false;
    }

    public function getModelNameAttribute(){
        return strtoupper(class_basename($this->model_type));
    }

    public function getModelSpanAttribute(){
        $modelName = $this->model_name;
        if($modelName == 'ENTRADA'){
            return "<a href='/servicios/{$this->model->folio}' class='btn btn-sm btn-primary'><i class='fa fa-car'></i> {$this->model->folio_short}</a>";
        }else if($modelName == 'REFACCION'){
            return "<a href='#' class='btn btn-sm btn-warning'><i class='fa fa-cube'></i> Refaccion</a>";
        }else if($modelName == 'VENTA'){
            return "<a href='#' class='btn btn-sm btn-info'><i class='fa fa-shopping-cart'></i> Venta {$this->id_paddy}</a>";
        }
    }

    public function getNumeroReporteAttribute(){
        return $this->model?->numero_reporte ?? 'N/A';
    }

    public function getFechaPagoSpanAttribute(){
        if($this->fecha_pago){
            $fecha = Carbon::parse($this->fecha_pago)->format('d-M-Y');
            return "<label class='text-success'> {$fecha} <i class='fa fa-check'></i></label>";

        }else{
            return "<span class='badge badge-warning'><i class='fa fa-clock'></i> PENDIENTE</span>";
        }
    }

}
