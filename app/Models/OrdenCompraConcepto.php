<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraConcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_compra_id',
        'presupuesto_material_id',
        'numero_parte',
        'descripcion',
        'unidad_venta',
        'cantidad',
        'precio',
        'entregado',
    ];
    
    public function orden_compra(){
        return $this->belongsTo(OrdenCompra::class, 'orden_compra_id');
    }

    public function solicitud_compra_conceptos(){
        return $this->belongsToMany(SolicitudCompraConcepto::class, 'orden_compra_concepto_solicitud_compra_concepto', 'compra_concepto_id', 'solicitud_concepto_id');
    }

    public function getSubtotalAttribute(){
        return floatval($this->cantidad) * floatval($this->precio);
    }

    public function getIvaAttribute(){
        return $this->subtotal * ($this->orden_compra->tasa_iva / 100);
    }

    public function getTotalAttribute(){
        return $this->subtotal * (1 + ($this->orden_compra->tasa_iva / 100));

    }
}
