<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendiente extends BaseModel
{
    use HasFactory;

    protected $table = 'pendientes';

    protected $fillable = [
        ' ',
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
        return $this->fecha_promesa ? $this->fecha_promesa->format('d/m/Y h:i A') : null;
    }

    public function getFechaTerminadoFormatAttribute(){
        return $this->fecha_terminado ? $this->fecha_terminado->format('d/m/Y h:i A') : null;
    }
}
