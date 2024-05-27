<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'url',
    ];

    public function getLocationPathAttribute(){
        return asset($this->attributes['url']);
    }
}
