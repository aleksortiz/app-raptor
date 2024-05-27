<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoPresupuesto extends Model
{
    use HasFactory;

    protected $table = 'contacto_presupuesto';

    protected $fillable = [
        'contacto_id',
        'presupuesto_id',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->orden = ContactoPresupuesto::where('presupuesto_id', $model->presupuesto->id)->count() + 1;
        });
    }

    public function presupuesto(){
        return $this->belongsTo(Presupuesto::class);
    }

    public function contacto(){
        return $this->belongsTo(Contacto::class);
    }

    public function correosEnviados(){
        
    }
}
