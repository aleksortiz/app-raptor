<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiculoParte extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'vehiculo_id',
        'descripcion',
        'numero_parte',
        'cantidad',
        'costo',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function getFechaFormatAttribute(){
        return Carbon::parse($this->fecha)->format('d/M/Y');
    }

    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = trim(strtoupper($value));
    }

    public function getImporteAttribute(){
        return $this->cantidad * $this->costo;
    }
}
