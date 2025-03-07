<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiculoGasto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'vehiculo_id',
        'descripcion',
        'estimacion',
        'monto',
        'fecha',
    ];

    public function getFechaFormatAttribute(){
        return Carbon::parse($this->fecha)->format('d/M/Y');
    }

    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = trim(strtoupper($value));
    }
}
