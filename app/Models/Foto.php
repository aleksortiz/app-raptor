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

    public function model()
    {
        return $this->morphTo();
    }
    
    public function getLocationAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->url);
        return $location;
    }

    public function getLocationThumbAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        $location = str_replace($bucket, '', $this->url_thumb);
        return $location;
    }

    public function getCompleteUrlAttribute(){
        $bucket = env('AWS_BUCKET_URL');
        // if url contains
        if (str_contains($this->url, $bucket)) {
            return $this->url;
        }
        else{
            return $bucket . $this->url;
        }
    }

    public function getCompleteThumbUrlAttribute(){
        if (!$this->url_thumb) {
            return $this->getCompleteUrlAttribute();
        }
        $bucket = env('AWS_BUCKET_URL');
        if (str_contains($this->url_thumb, $bucket)) {
            return $this->url_thumb;
        }
        else{
            return $bucket . $this->url_thumb;
        }
    }
}
