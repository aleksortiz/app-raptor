<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preconcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'cantidad',
        'mano_de_obra',
        'contratistas',
        'unidad_medida',
        'comentarios',
    ];

    public function materiales(){
        return $this->hasMany(PreconceptoMaterial::class);
    }

    // public function getImporteMaterialesAttribute(){
    //     if($this->materiales){
    //         return $this->materiales->reduce(function($carry, $item){
    //             return $carry + $item->importe;
    //         });
    //     }
    //     return 0;
    // }

    // public function getImporteTotalAttribute(){
    //     $importe = $this->importe_materiales;
    //     $importe += ($this->mano_de_obra + $this->precio) * $this->cantidad;
    //     return $importe;
    // }

    public function setUnidadMedidaAttribute($value){
        $this->attributes['unidad_medida'] = strtoupper($value);
    }

    public function getMaterialesPuAttribute(){
        return $this->materiales->sum('importe');
    }

    public function getPrecioUnitarioAttribute(){
        return $this->mano_de_obra
        + $this->contratistas
        + $this->materiales_pu;
    }

    public function getImporteAttribute(){
        return $this->precio_unitario * floatval($this->cantidad);
    }
}
