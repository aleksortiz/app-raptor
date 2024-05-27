<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCompraConcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitud_compra_id',
        'presupuesto_material_id',
        'numero_parte',
        'descripcion',
        'unidad_venta',
        'cantidad_solicitada',
        'precio',
    ];

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class, 'solicitud_compra_id');
    }

    public function material_presupuesto(){
        return $this->belongsTo(PresupuestoMaterial::class, 'presupuesto_material_id');
    }

    public function compra_conceptos(){
        return $this->belongsToMany(OrdenCompraConcepto::class, 'orden_compra_concepto_solicitud_compra_concepto', 'solicitud_concepto_id', 'compra_concepto_id');
    }
}
