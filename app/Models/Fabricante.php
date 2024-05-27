<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Fabricante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];
    
    public function setNombreAttribute($value){
        $this->attributes['nombre'] = trim(strtoupper($value));
    }

    public function entradas (){
        return $this->hasMany(Entrada::class);
    }

    public static function Catalog(){
        $data = Cache::get('fabricantes', null);
        if($data == null){
            $fabricantes = Fabricante::orderBy('nombre')->pluck('nombre');
            $data = array_map(function($elem) {
                return strtoupper(trim($elem));
            }, $fabricantes->toArray());
            Cache::set('fabricantes', $data, 60*60*4); // 4 Hrs
        }
        return $data;
    }
}
