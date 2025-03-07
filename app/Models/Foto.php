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
        'url_thumb',
        'public',
    ];
    
    public function getLocationAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->url);
        return $location;
    }
}
