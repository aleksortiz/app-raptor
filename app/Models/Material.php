<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Material extends BaseModel
{
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [
        'numero_parte',
        'categoria',
        'descripcion',
        'unidad_medida',
        'costo',
        'precio',
        'existencia',
        'comentarios',
        'active'
    ];

    // public function inventario(){
    //     return $this->hasMany(Inventario::class);
    // }

    // public function current_stock()
    // {
    //     return $this->hasOne(Inventario::class, 'material_id')->where('sucursal_id', Auth::user()->sucursal_default);
    // }    

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
