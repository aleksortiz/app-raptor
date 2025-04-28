<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entrada;
use App\Models\Personal;

class Asignacion extends Model
{
    use HasFactory;

    protected $table = 'asignaciones';

    protected $fillable = [
        'entrada_id',
        'personal_id',
        'descripcion_trabajo',
        'fecha_realizado',
        'estado'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_realizado'
    ];

    protected $casts = [
        'fecha_realizado' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Obtiene la entrada asociada a esta asignación
     */
    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    /**
     * Obtiene el personal asignado a esta tarea
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    /**
     * Obtiene la fecha de asignación (created_at)
     */
    public function getFechaAsignacionAttribute()
    {
        return $this->created_at;
    }
}
