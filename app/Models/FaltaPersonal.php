<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaltaPersonal extends Model
{
    use HasFactory;
    
    protected $table = 'falta_personal';
    public $timestamps = false;

    protected $fillable = [
        'personal_id',
        'fecha'
    ];

}
