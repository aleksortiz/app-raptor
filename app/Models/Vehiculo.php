<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
        'precio_venta',
        'estado',
        'slug',
        'descripcion_venta'
    ];

    // boot and generate slug
    protected static function boot(){
        parent::boot();
        static::creating(function($vehiculo){
            $vehiculo->slug = $vehiculo->generateSlug($vehiculo->descripcion);
        });
    }

    //create slug from descripcion
    public function generateSlug($descripcion){
        $slug = Str::slug($descripcion);
        $count = Vehiculo::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

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

    public function fotos_publicas(){
        return $this->fotos()->where('public', true);
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
