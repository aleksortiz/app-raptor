<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoMaterial extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_materiales';
    
    protected $fillable = [
        'presupuesto_id',
        'presupuesto_concepto_id',
        'numero_parte',
        'descripcion',
        'unidad_venta',
        'cantidad',
        'precio',
        'comentarios',
        'active',
    ];

    public function getImporteAttribute(){
        return floatval($this->cantidad) * floatval($this->precio);
    }

    public function concepto(){
        return $this->belongsTo(PresupuestoConcepto::class, 'presupuesto_concepto_id');
    }

    public function solicitudes_compra_conceptos(){
        return $this->hasMany(SolicitudCompraConcepto::class, 'presupuesto_material_id');
    }
}
