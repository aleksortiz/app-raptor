<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoPersonal extends Model
{
    use HasFactory;

    protected $table = 'pago_personal';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'personal_id',
        'entrada_id',
        'porcentaje',
        'pago',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }

    public function getFolioAttribute()
    {
        if ($this->entrada_id) {
            return $this->entrada->folio_short;
        }
        return 'TALLER';
    }
}
