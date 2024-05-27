<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoEnvioCorreo extends Model
{
    use HasFactory;

    protected $table = 'contacto_envio_correo';

    protected $fillable = [
        'contacto_id',
        'envio_correo_id',
    ];

    public function envio_correo(){
        return $this->belongsTo(EnvioCorreo::class);
    }

    public function contacto(){
        return $this->belongsTo(Contacto::class);
    }
}
