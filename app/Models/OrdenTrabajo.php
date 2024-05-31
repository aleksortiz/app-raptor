<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenTrabajo extends BaseModel
{
    use HasFactory;

    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'user_id',
        'entrada_id',
        'personal_id',
        'monto',
        'notas'
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function pagos()
    {
        return $this->hasMany(OrdenTrabajoPago::class);
    }

    public function getPagadoAttribute()
    {
        return $this->pagos->sum('monto');
    }

    public function getPendienteAttribute()
    {
        return $this->monto - $this->pagado;
    }
    
}
