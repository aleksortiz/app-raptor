<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreconceptoMaterial extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'preconcepto_materiales';


    protected $fillable = [
        'preconcepto_id',
        'numero_parte',
        'descripcion',
        'unidad_medida',
        'cantidad',
        'precio'
    ];


    public function preconcepto(){
        return $this->belongsTo(Preconcepto::class);
    }

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }

    public function setUnidadMedidaAttribute($value){
        $this->attributes['unidad_medida'] = strtoupper($value);
    }
    
    public function setNumeroParteAttribute($value){
        $this->attributes['numero_parte'] = strtoupper($value);
    }
}