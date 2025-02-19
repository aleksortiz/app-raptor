<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'marca',
        'modelo',
        'year',
        'color',
        'placa',
        'serie',
        'factura',
        'pedimento',
        'costo',
        'flete',
        'importacion',
        'precio_venta',
        'estado',
    ];

    public function partes(){
        return $this->hasMany(VehiculoParte::class);
    }

    public function getDescripcionAttribute(){
        return "{$this->marca} {$this->modelo} {$this->year} {$this->color}";
    }

    public function getDescripcionShortAttribute(){
        return "{$this->marca} {$this->modelo} {$this->year}";
    }

    public function fotos(){
        return $this->morphMany(Foto::class, 'model');
    }

    public function gastos(){
        return $this->hasMany(VehiculoGasto::class);
    }

    public function setMarcaAttribute($value){
        $this->attributes['marca'] = trim(strtoupper($value));
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = trim(strtoupper($value));
    }

    public function setColorAttribute($value){
        $this->attributes['color'] = trim(strtoupper($value));
    }

    public function setPlacaAttribute($value){
        $this->attributes['placa'] = trim(strtoupper($value));
    }

    public function setFacturaAttribute($value){
        $this->attributes['factura'] = trim(strtoupper($value));
    }

    public function setPedimentoAttribute($value){
        $this->attributes['pedimento'] = trim(strtoupper($value));
    }

    public function setSerieAttribute($value){
        $this->attributes['serie'] = trim(strtoupper($value));
    }

    public function getTotalGastosAttribute(){
        return $this->gastos->sum('monto');
    }

    public function getTotalPartesAttribute(){
        return $this->partes->sum('importe');
    }
}
