<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoModel extends Model
{
    protected $table = 'contacto_model';

    use HasFactory;

    protected $fillable = [
        'contacto_id',
        'model_id',
        'model_type',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->orden = ContactoModel::where('model_id', $model->model_id)
            ->where('model_type', $model->model_type)
            ->count() + 1;
        });
    }
    
}
