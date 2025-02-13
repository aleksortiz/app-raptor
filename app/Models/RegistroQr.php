<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroQr extends Model
{
    protected $fillable = [
        'numero_reporte',
        'cliente_nombre',
        'telefono',
        'correo',
        'tipo',
        'marca',
        'modelo',
        'year',
        'color',
        'fecha_cita',
        'ine_frontal',
        'ine_trasera',
        'orden_admision',
    ];

    protected $dates = [
        'fecha_cita',
    ];

    public function setNumeroReporteAttribute($value){
        $this->attributes['numero_reporte'] = trim(strtoupper($value));
    }

    public function setClienteNombreAttribute($value){
        $this->attributes['cliente_nombre'] = trim(ucwords($value));
    }

    public function setTipoAttribute($value){
        $this->attributes['tipo'] = trim(ucwords($value));
    }

    public function setMarcaAttribute($value){
        $this->attributes['marca'] = trim(ucwords($value));
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = trim(ucwords($value));
    }

    public function setColorAttribute($value){
        $this->attributes['color'] = trim(ucwords($value));
    }
}
