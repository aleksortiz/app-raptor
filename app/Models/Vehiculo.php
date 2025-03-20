<?php

namespace App\Models;

use App\Mail\VehiculoVentaMailable;
use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
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
        'descripcion_venta',
        'moneda',
        'cotizacion_usd',
        'numero_lote',
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
        if(!$this->gastos){
            return 0;
        }
        return $this->gastos->sum('monto');
    }

    public function getTotalGastosEstimacionAttribute(){
        if(!$this->gastos){
            return 0;
        }
        return $this->gastos->sum('estimacion');
    }

    public function getTotalPartesAttribute(){
        return $this->partes->sum('importe');
    }

    public function getUtilidadFinalAttribute(){
        return $this->precio_venta - $this->totalGastos - $this->totalPartes;
    }

    public function getUtilidadEstimadaAttribute(){
        return $this->precio_venta - $this->totalGastosEstimacion - $this->totalPartes;
    }

    public function sendMail($address){
        $mailable = new VehiculoVentaMailable($this);
        Mail::to($address)->queue($mailable);
    }

    public function getPrecioVentaMxnAttribute(){
        if($this->moneda == 'MXN'){
            return $this->precio_venta;
        }
        if(!$this->cotizacion_usd || $this->cotizacion_usd <= 0){
            return $this->precio_venta;
        }
        return $this->precio_venta * $this->cotizacion_usd;
    }

    public function vehiculos_cuenta(){
        return $this->hasMany(VehiculoCuenta::class);
    }

    public function getSumaVehiculosCuentaAttribute(){
        if($this->vehiculos_cuenta->isEmpty()){
            return 0;
        }
        return $this->vehiculos_cuenta->sum('monto');
    }

    public function pagares(){
        return $this->hasMany(VehiculoPagare::class)->orderBy('fecha', 'asc');
    }

    public function venta(){
        return $this->hasOne(VehiculoVenta::class);
    }


}
