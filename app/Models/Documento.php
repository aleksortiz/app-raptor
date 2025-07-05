<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'tipo',
        'model_id',
        'model_type',
    ];

    public function model(){
        return $this->morphTo();
    }
}
