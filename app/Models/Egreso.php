<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha',
        'concepto',
        'monto',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFechaFormatAttribute(){
        $date = Carbon::parse($this->fecha);
        $format = 'M/d/Y h:i A';
        if ($date->year = Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }
}
