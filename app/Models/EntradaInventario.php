<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaInventario extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente',
        'telefono',
        'marca',
        'modelo',
        'year',
        'kilometros',
        'color',
        'placas',
        'notas',
        'gasolina',
        'inventario',
        'testigos',
        'carroceria',
        'mecanica',
        'servicios_extras',
        'firma',
        'diagrama',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setClienteAttribute($value){
        $this->attributes['cliente'] = trim(strtoupper($value));
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

    public function setPlacasAttribute($value){
        $this->attributes['placas'] = trim(strtoupper($value));
    }

    public function getVehiculoAttribute(){
        $veh = "{$this->marca} {$this->modelo} {$this->year} {$this->color}";
        return trim($veh);
    }



}
