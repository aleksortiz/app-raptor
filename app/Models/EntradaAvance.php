<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaAvance extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrada_id',
        'carroceria',
        'preparado',
        'pintura',
        'armado',
        'terminado',
        'notificacion_entrega',
    ];

    protected $cast = [
        'carroceria' => 'datetime',
        'preparado' => 'datetime',
        'pintura' => 'datetime',
        'armado' => 'datetime',
        'terminado' => 'datetime',
        'notificacion_entrega' => 'datetime',
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function getCarroceriaFormatAttribute()
    {
        return $this->carroceria ? Carbon::parse($this->carroceria)->format('d/m/Y h:i A') : null;
    }

    public function getPreparadoFormatAttribute()
    {
        return $this->preparado ? Carbon::parse($this->preparado)->format('d/m/Y h:i A') : null;
    }

    public function getPinturaFormatAttribute()
    {
        return $this->pintura ? Carbon::parse($this->pintura)->format('d/m/Y h:i A') : null;
    }

    public function getArmadoFormatAttribute()
    {
        return $this->armado ? Carbon::parse($this->armado)->format('d/m/Y h:i A') : null;
    }

    public function getTerminadoFormatAttribute()
    {
        return $this->terminado ? Carbon::parse($this->terminado)->format('d/m/Y h:i A') : null;
    }

    public function getNotificacionEntregaFormatAttribute()
    {
        return $this->notificacion_entrega ? Carbon::parse($this->notificacion_entrega)->format('d/m/Y h:i A') : null;
    }

    public function getEstadoAttribute()
    {
        if ($this->notificacion_entrega) {
            return 'PENDIENTE ENTREGA';
        } elseif ($this->terminado) {
            return 'TERMINADO';
        } elseif ($this->armado) {
            return 'ARMADO';
        } elseif ($this->pintura) {
            return 'PINTURA';
        } elseif ($this->preparado) {
            return 'PREPARADO';
        } elseif ($this->carroceria) {
            return 'CARROCERIA';
        }
        return null;
    }
}
