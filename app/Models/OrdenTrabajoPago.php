<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenTrabajoPago extends BaseModel
{
    use HasFactory;
    
    protected $table = 'orden_trabajo_pagos';
    
    protected $fillable = [
        'orden_trabajo_id',
        'monto'
    ];

}
