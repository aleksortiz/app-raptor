<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Video Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para el almacenamiento de videos en la aplicación.
    | Puedes cambiar estos valores según tus necesidades.
    |
    */

    // Disco de almacenamiento (public o s3)
    'storage_disk' => env('VIDEO_STORAGE_DISK', 'public'),

    // Directorio base para videos
    'videos_path' => env('VIDEO_PATH', 'videos'),

    // Directorio para thumbnails
    'thumbnails_path' => env('VIDEO_THUMBNAILS_PATH', 'videos/thumbnails'),

    // Tamaño máximo de video en KB (100MB por defecto)
    'max_size' => env('VIDEO_MAX_SIZE', 102400),

    // Tamaño máximo de thumbnail en KB (5MB por defecto)
    'thumbnail_max_size' => env('VIDEO_THUMBNAIL_MAX_SIZE', 5120),

    // Formatos de video permitidos
    'allowed_mimes' => [
        'mp4',
        'mov',
        'avi',
        'wmv',
        'flv',
        'webm',
    ],

    // Formatos de thumbnail permitidos
    'thumbnail_mimes' => [
        'jpg',
        'jpeg',
        'png',
    ],

    // Calidad de compresión para thumbnails (1-100)
    'thumbnail_quality' => env('VIDEO_THUMBNAIL_QUALITY', 80),

    // Auto-generar thumbnail desde el video (requiere FFmpeg)
    'auto_generate_thumbnail' => env('VIDEO_AUTO_THUMBNAIL', false),

    // Tiempo en segundos del frame para el thumbnail
    'thumbnail_frame_time' => env('VIDEO_THUMBNAIL_FRAME', 1),

    // Habilitar streaming de video (requiere configuración adicional)
    'enable_streaming' => env('VIDEO_ENABLE_STREAMING', false),

    // URL pública base para videos (si es diferente de APP_URL)
    'public_url' => env('VIDEO_PUBLIC_URL', null),

    // Eliminar videos físicos al eliminar el registro
    'delete_files_on_model_delete' => env('VIDEO_DELETE_FILES', true),

    // Límite de videos por modelo (0 = ilimitado)
    'max_videos_per_model' => env('VIDEO_MAX_PER_MODEL', 0),

    /*
    |--------------------------------------------------------------------------
    | Video Recording Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la grabación de videos desde el navegador.
    |
    */

    // Duración máxima de grabación en segundos (0 = ilimitado)
    'max_recording_duration' => env('VIDEO_MAX_RECORDING_DURATION', 300), // 5 minutos

    // Codec de video para grabación
    'recording_codec' => env('VIDEO_RECORDING_CODEC', 'vp9'),

    // MIME type para grabación
    'recording_mime_type' => env('VIDEO_RECORDING_MIME', 'video/webm'),

    /*
    |--------------------------------------------------------------------------
    | S3 Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración específica para AWS S3.
    | Estas configuraciones sobrescriben las de filesystems.php
    |
    */

    's3' => [
        'bucket' => env('AWS_BUCKET'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'visibility' => env('AWS_VIDEO_VISIBILITY', 'public'),
        'url' => env('AWS_BUCKET_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para optimización de rendimiento.
    |
    */

    // Cachear URLs generadas (en segundos, 0 = sin caché)
    'cache_urls' => env('VIDEO_CACHE_URLS', 0),

    // Lazy loading de videos en listas
    'lazy_load' => env('VIDEO_LAZY_LOAD', true),

    // Preload strategy (none, metadata, auto)
    'preload' => env('VIDEO_PRELOAD', 'metadata'),

];

