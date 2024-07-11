<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlotillaUnidad extends Model
{
    use HasFactory;

    protected $table = 'flotilla_unidades';

    protected $fillable = [
        'flotilla_id',
        'fabricante',
        'modelo',
        'year',
        'serie',
        'placas',
        'estado',
        'kilometraje',
    ];

    protected $attributes = [
        'estado' => 'NUEVO',
        'kilometraje' => 0
    ];

    public function servicios(){
        return $this->hasMany(ServicioFlotilla::class, 'flotilla_unidad_id');
    }

    public function getVehiculoAttribute(){
        return $this->fabricante . ' ' . $this->modelo . ' ' . $this->year;
    }
    
    public function setFabricanteAttribute($value){
        $this->attributes['fabricante'] = strtoupper($value);
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = strtoupper($value);
    }

    public function setSerieAttribute($value){
        $this->attributes['serie'] = strtoupper($value);
    }

    public function setPlacasAttribute($value){
        $this->attributes['placas'] = strtoupper($value);
    }

    

}
