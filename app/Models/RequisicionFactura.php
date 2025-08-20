<?php

namespace App\Models;

use App\Models\shared\BaseModel;

class RequisicionFactura extends BaseModel
{
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

    protected $attributes = [
        'uso_cfdi' => 'G03',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function getNombreClienteAttribute()
    {
        if ($this->cliente) {
            return $this->cliente->nombre;
        }

        return $this->aseguradora;
    }
}
