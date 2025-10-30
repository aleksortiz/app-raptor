<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Video extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'url',
        'thumbnail',
        'filename',
        'mime_type',
        'size',
        'duration',
        'public',
        'description',
    ];

    protected $casts = [
        'public' => 'boolean',
        'size' => 'integer',
        'duration' => 'integer',
    ];

    /**
     * Relación polimórfica
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Obtener la URL completa del video
     */
    public function getCompleteUrlAttribute()
    {
        // Si la URL ya es completa (http/https), retornarla tal cual
        if (str_contains($this->url, 'http')) {
            return $this->url;
        }
        
        // Verificar si el archivo existe localmente en storage/app/public
        if (Storage::disk('public')->exists($this->url)) {
            // Usar URL local de Laravel
            return Storage::url($this->url);
        }
        
        // Si no existe localmente pero hay bucket configurado, intentar S3
        $bucket = env('AWS_BUCKET_URL');
        if ($bucket) {
            if (str_contains($this->url, $bucket)) {
                return $this->url;
            }
            return $bucket . $this->url;
        }
        
        // Por defecto, usar storage local
        return Storage::url($this->url);
    }

    /**
     * Obtener la URL completa del thumbnail
     */
    public function getCompleteThumbnailUrlAttribute()
    {
        if (!$this->thumbnail) {
            return null;
        }

        // Si la URL ya es completa (http/https), retornarla tal cual
        if (str_contains($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        
        // Verificar si el archivo existe localmente en storage/app/public
        if (Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::url($this->thumbnail);
        }
        
        // Si no existe localmente pero hay bucket configurado, intentar S3
        $bucket = env('AWS_BUCKET_URL');
        if ($bucket) {
            if (str_contains($this->thumbnail, $bucket)) {
                return $this->thumbnail;
            }
            return $bucket . $this->thumbnail;
        }
        
        // Por defecto, usar storage local
        return Storage::url($this->thumbnail);
    }

    /**
     * Obtener el tamaño formateado
     */
    public function getFormattedSizeAttribute()
    {
        if (!$this->size) {
            return 'Desconocido';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Obtener la duración formateada
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return '00:00';
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
