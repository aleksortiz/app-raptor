<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function model(){
        return $this->morphTo();
    }
}
