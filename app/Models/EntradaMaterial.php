<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'entrada_material';

    protected $fillable = [
        'entrada_id',
        'material_id',
        'numero_parte',
        'material',
        'unidad_medida',
        'precio',
        'cantidad',
        'pedido_concepto_id',
        'vale_id',
    ];

    public function entrada(){
        return $this->belongsTo(Entrada::class);
    }

    public function getImporteAttribute(){
        return $this->precio * $this->cantidad;
    }

    public function vale_material(){
        return $this->hasOne(ValeMaterial::class, 'id', 'vale_id');
    }
}
