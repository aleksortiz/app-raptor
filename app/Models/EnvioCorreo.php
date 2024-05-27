<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioCorreo extends Model
{
    use HasFactory;
    
    protected $table = 'envio_correos';

    protected $fillable = [
        'titulo',
        'mensaje',
        'usuario_id',
        'model_type',
        'model_id',
    ];

    public function contactos()
    {
        return $this->belongsToMany(Contacto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
