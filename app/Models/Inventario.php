<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'material_id',
        'sucursal_id',
        'minimo',
        'existencia',
        'costo',
        'precio',
        'activo'
    ];

    protected $attributes = [
        'activo' => true
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
