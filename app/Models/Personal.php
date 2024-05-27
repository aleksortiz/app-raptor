<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'nombre',
        'sueldo',
        'telefono',
        'domicilio',
        'contacto_emergencia',
        'notas',
        'activo',
    ];

    public function getPagos($date)
    {
        return PagoPersonal::where('personal_id', $this->id)->where('fecha', $date)->get();
    }

    public function getFalta($date){
        return FaltaPersonal::where('personal_id', $this->id)->where('fecha', $date)->first();
    }
    
    public function getPorcentaje($date)
    {
        $pagos = $this->getPagos($date);
        $porcentaje = 0;
        foreach ($pagos as $pago) {
            $porcentaje += $pago->porcentaje;
        }
        return $porcentaje;
    }

    public function getSueldoDiarioAttribute()
    {
        return $this->sueldo / 6;
    }

}
