<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Proyecto extends CancelableModel
{
    use HasFactory;

    protected $fillable = [
        'presupuesto_id',
        'titulo',
        'fecha_inicio',
        'fecha_entrega',
        'numero_po',
        'notas',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->user_id = $user->id;
            $model->concluido = false;
        });
    }

    public function presupuesto(){
        return $this->belongsTo(Presupuesto::class);
    }

    public function solicitudes_compra(){
        return $this->hasMany(SolicitudCompra::class, 'proyecto_id');
    }
}
