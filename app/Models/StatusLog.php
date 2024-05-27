<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'status',
        'comments',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->user_id = $user->id;
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusColorAttribute(){
        $color = 'btn-primary';

        switch ($this->status) {
            case 'PENDIENTE AUTORIZAR':
            case 'EN PROCESO':
                $color = 'btn-warning';
                break;

            case 'AUTORIZADO':
                $color = 'btn-success';
                break;

            case 'RECHAZADO':
                $color = 'btn-danger';
                break;

            case 'BORRADOR':
                $color = 'btn-primary';
                break;
        }

        return $color;
    }
}
