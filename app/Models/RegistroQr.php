<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;

class RegistroQr extends BaseModel
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
        'ine_reverso',
        'orden_admision',
        'active',
    ];

    protected $dates = [
        'fecha_cita',
    ];

    public function setNumeroReporteAttribute($value){
        $this->attributes['numero_reporte'] = trim(strtoupper($value));
    }

    public function setClienteNombreAttribute($value){
        $this->attributes['cliente_nombre'] = trim(strtoupper($value));
    }

    public function setTipoAttribute($value){
        $this->attributes['tipo'] = trim(strtoupper($value));
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

    public function getVehiculoAttribute(){
        return $this->marca . ' ' . $this->modelo . ' ' . $this->year . ' ' . $this->color;
    }

    public function getFechaCitaFormatAttribute(){
        return Carbon::parse($this->fecha_cita)->format('d-M-Y h:i A');
    }

    public function getTipoSpanAttribute(){
        $tipo = $this->tipo_format;
        $icon = '';
        $color = '';
        if($tipo == 'REPARACION' || $tipo == 'REPARACIÓN'){
            $color = 'warning';
            $icon = 'fa-wrench';
        }else if($tipo == 'VALUACION' || $tipo == 'VALUACIÓN'){
            $color = 'primary';
            $icon = 'fa-file-alt';
        }
        return "<button class='btn btn-xs btn-$color'><i class='fa $icon'></i> $tipo</button>";
    }

    public function getTipoFormatAttribute(){
        return str_replace('CION', 'CIÓN', $this->tipo);
    }

    public function getOrdenAdmisionLocationAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->orden_admision);
        return $location;
    }

    public function getIneFrontalLocationAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->ine_frontal);
        return $location;
    }

    public function getIneReversoLocationAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->ine_reverso);
        return $location;
    }
}
