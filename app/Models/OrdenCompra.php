<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class OrdenCompra extends CancelableModel
{
    use HasFactory;
    
    protected $table = 'ordenes_compra';

    protected $fillable = [
        'proyecto_id',
        'proveedor_id',
        'tasa_iva',
        'nombre',
        'estatus',
        'notas',
        'emergente'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->user_id = $user->id;
        });

        self::created(function($model){
            StatusLog::create([
                'model_id' => $model->id,
                'model_type' => OrdenCompra::class,
                'status' => $model->estatus,
            ]);
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conceptos(){
        return $this->hasMany(OrdenCompraConcepto::class, 'orden_compra_id');
    }

    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function contactos(){
        return $this->morphToMany(Contacto::class, 'model', 'contacto_model');
    }

    public function envios_correo(){
        return $this->morphMany(EnvioCorreo::class, 'model');
    }

    public function getSubtotalAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->subtotal;
            });
        }
        return 0;
    }

    public function getIvaAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->iva;
            });
        }
        return 0;
    }

    public function getTotalAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->total;
            });
        }
        return 0;
    }

    public function status_logs(){
        return $this->morphMany(StatusLog::class, 'model');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class, 'model');
    }


    public function getEstatusColorAttribute(){
        $color = 'btn-primary';

        switch ($this->estatus) {
            case 'EN PROCESO':
            case 'PENDIENTE AUTORIZAR':
                $color = 'btn-warning';
                break;

            case 'AUTORIZADO':
            case 'ENVIADO':
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
        if(!$log){
            return '';
        }

        $date = Carbon::parse($log->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getRechazadoPorAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        if(!$log){
            return '';
        }
        return $log->user->name;
    }

    public function getFechaRechazoAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        if(!$log){
            return '';
        }
        $date = Carbon::parse($log->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getComentariosAutorizacionAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'AUTORIZADO')->first();
        if(!$log){
            return '';
        }
        return $log->comments;
    }

    public function getMotivosRechazoAttribute(){
        $log = $this->status_logs->sortByDesc('created_at')->where('status', 'RECHAZADO')->first();
        if(!$log){
            return '';
        }
        return $log->comments;
    }
    
    public function generateName(){
        $name = substr($this->proyecto->titulo, 0, 7);

        $consecutivo = OrdenCompra::where('proyecto_id', $this->proyecto_id)
        ->where('nombre', '!=' ,'PENDIENTE')->count();
        $consecutivo++;
        $consecutivo = str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        $name =  "$name-$consecutivo";
        if($this->emergente){
            $name .= "EM";
        }

        return $name;
    }
}
