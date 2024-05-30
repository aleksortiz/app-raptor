<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends BaseModel
{
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [
        'numero_parte',
        'categoria',
        'descripcion',
        'unidad_medida',
        'precio',
        'existencia',
        'comentarios',
        'active'
    ];

    protected $attributes = [
        'existencia' => 0,
    ];
    
    public function setNumeroParteAttribute($value){
        $this->attributes['numero_parte'] = strtoupper($value);
    }

    public function setCategoriaAttribute($value){
        $this->attributes['categoria'] = strtoupper($value);
    }

    public function setUnidadMedidaAttribute($value){
        $this->attributes['unidad_medida'] = strtoupper($value);
    }
}
