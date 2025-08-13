<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionFactura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'model_id',
        'model_type',
        'uso_cfdi',
        'forma_pago',
        'descripcion',
        'monto',
        'aseguradora',
        'numero_factura',
        'fecha_facturacion',
        'fecha_pago',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
