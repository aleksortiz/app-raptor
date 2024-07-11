<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioFlotilla extends Model
{
    use HasFactory;

    protected $table = 'servicio_flotillas';

    protected $fillable = [
        'flotilla_unidad_id',
        'tipo_servicio',
        'descripcion',
        'fecha_servicio',
        'costo',
        'kilometraje',
    ];
}
