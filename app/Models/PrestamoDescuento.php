<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrestamoDescuento extends Model
{
    protected $fillable = [
        'prestamo_id',
        'week',
        'year',
        'fecha',
        'monto',
    ];

    public function prestamo(){
        return $this->belongsTo(Prestamo::class);
    }

    public function getPagadoAttribute(){
        return Carbon::today() >= $this->fecha;
    }
}
