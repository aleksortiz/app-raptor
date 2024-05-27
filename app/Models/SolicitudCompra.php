<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class SolicitudCompra extends CancelableModel
{
    use HasFactory;

    protected $table = 'solicitudes_compra';

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->user_id = $user->id;
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function conceptos(){
        return $this->hasMany(SolicitudCompraConcepto::class, 'solicitud_compra_id');
    }

    public function status_logs(){
        return $this->morphMany(StatusLog::class, 'model');
    }

    public function getEstatusColorAttribute(){
        $color = 'btn-primary';

        switch ($this->estatus) {
            case 'PENDIENTE AUTORIZAR':
                $color = 'btn-warning';
                break;

            case 'AUTORIZADO':
                $color = 'btn-success';
                break;

            case 'RECHAZADO':
                $color = 'btn-danger';
                break;
        }

        return $color;
    }

    public function autorizado_por(){
        return $this->belongsTo(User::class, 'authorized_by');
    }

    public function getFechaAutorizacionAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'AUTORIZADO')->first();
        $date = Carbon::parse($log->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getRechazadoPorAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        return $log->user->name;
    }

    public function getFechaRechazoAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        $date = Carbon::parse($log->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getComentariosAutorizacionAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'AUTORIZADO')->first();
        return $log->comments;
    }

    public function getMotivosRechazoAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        return $log->comments;
    }
}
