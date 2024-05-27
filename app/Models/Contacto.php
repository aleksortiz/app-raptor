<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PDO;

class Contacto extends CancelableModel
{
    use HasFactory;
    protected $table = 'contactos';

    protected $fillable = [
        'model_id',
        'model_type',
        'nombre',
        'correo',
        'departamento',
        'prefijo',        
    ];
    
    public function getDeptoAttribute(){
        if($this->attributes['departamento']){
            return $this->attributes['departamento'];
        }
        return "N/A";
    }

    public function getPrefijoNombreAttribute(){
        return trim(strtoupper("{$this->attributes['prefijo']} {$this->attributes['nombre']}"));
    }
    
    public function getPrefijoNombreCorreoAttribute(){
        return strtoupper("{$this->attributes['prefijo']} {$this->attributes['nombre']}") . " (" . $this->attributes['correo'] . ")";
    }

    public function envios_correo()
    {
        return $this->belongsToMany(EnvioCorreo::class);
    }

    public function telefonos()
    {
        return $this->morphMany(NumeroTelefono::class, 'model')->orderBy('id', 'desc');
    }

    public function model(){
        return $this->morphTo();
    }
}

