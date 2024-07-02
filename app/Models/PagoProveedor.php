<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoProveedor extends Model
{
    use HasFactory;

    protected $table = 'pagos_proveedor';

    protected $fillable = [
        'fecha',
        'user_id',
        'proveedor_id',
        'monto',
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
