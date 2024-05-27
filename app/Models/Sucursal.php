<?php

namespace App\Models;

use App\Http\Traits\Common\CancelableModelTrait;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use CancelableModelTrait;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion',        
        'telefono',
        'emisor_id',
        'comentarios',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function emisor(){
        return $this->belongsTo(Emisor::class);
    }
}
