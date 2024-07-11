<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flotilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nombre',
        'notas',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function unidades(){
        return $this->hasMany(FlotillaUnidad::class);
    }
}
