<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiculoCuenta extends BaseModel
{
    use HasFactory;

    protected $table = 'vehiculo_cuentas';

    protected $fillable = [
        'vehiculo_id',
        'fecha',
        'vendedor',
        'descripcion',
        'monto',
        'notas',
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

    public function setVendedorAttribute($value){
        $this->attributes['vendedor'] = trim(strtoupper($value));
    }
}
