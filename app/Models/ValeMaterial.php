<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValeMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'vale_materiales';

    protected $fillable = [
        'user_id',
        'personal_id',
        'comentarios',
    ];

    public function materiales(){
        return $this->hasMany(EntradaMaterial::class, 'vale_id');
    }

    public function personal(){
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
