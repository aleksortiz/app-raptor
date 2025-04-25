<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendiente extends BaseModel
{
    use HasFactory;

    protected $table = 'pendientes';

    protected $fillable = [
        'user_id',
        'entrada_id',
        'descripcion',
        'fecha_promesa',
        'fecha_terminado',
    ];

    protected $casts = [
        'fecha_promesa' => 'datetime',
        'fecha_terminado' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFechaPromesaFormatAttribute(){
        $format = 'd/M/Y h:i A';
        return $this->fecha_promesa ? $this->fecha_promesa->format($format) : null;
    }

    public function getFechaTerminadoFormatAttribute(){
        $format = 'd/M/Y h:i A';
        return $this->fecha_terminado ? $this->fecha_terminado->format($format) : null;
    }
}
