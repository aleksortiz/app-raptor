{{-- 
    EJEMPLO DE USO DEL COMPONENTE VideoRecorder
    
    Este archivo muestra cómo integrar el componente VideoRecorder en tus vistas.
    Puedes copiar y adaptar estos ejemplos según tus necesidades.
--}}

{{-- 
    EJEMPLO 1: Uso en una vista Blade de Entrada
    
    En tu vista de detalles de Entrada (por ejemplo: resources/views/livewire/entrada/ver-entrada/tabs/tab-videos.blade.php)
--}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Videos de la Entrada</h2>
            
            {{-- 
                Incluir el componente Livewire VideoRecorder 
                - modelType: Nombre completo de la clase del modelo (App\Models\Entrada)
                - modelId: ID del registro al que se asociarán los videos
            --}}
            @livewire('video-recorder', [
                'modelType' => 'App\\Models\\Entrada',
                'modelId' => $entrada->id
            ])
        </div>
    </div>
</div>
@endsection

{{-- 
    EJEMPLO 2: Uso en una vista Blade de Valuación
    
    En tu vista de detalles de Valuación
--}}

{{-- 
<div class="tab-pane" id="tab_videos">
    <div class="container-fluid py-4">
        @livewire('video-recorder', [
            'modelType' => 'App\\Models\\Valuacion',
            'modelId' => $valuacion->id
        ])
    </div>
</div>
--}}

{{-- 
    EJEMPLO 3: Agregar un nuevo tab en la vista de Entrada existente
    
    1. En el archivo: app/Http/Livewire/Entrada/VerEntrada.php
       Agregar en el método render():
       
       public function render()
       {
           return view('livewire.entrada.ver-entrada.view', [
               'entrada' => $this->entrada,
               'activeTab' => $this->activeTab,
           ]);
       }
    
    2. En el archivo: resources/views/livewire/entrada/ver-entrada/view.blade.php
       Agregar en la lista de tabs (dentro de <ul class="nav nav-pills">):
       
       <li class="nav-item">
           <a class="nav-link {{ $activeTab == 12 ? 'active' : '' }}" 
              wire:click="$set('activeTab', 12)" 
              data-toggle="pill" 
              href="#tab_12">
               <i class="fa fa-video"></i> Videos
           </a>
       </li>
    
    3. Agregar el contenido del tab (dentro de <div class="tab-content">):
       
       <div class="tab-pane {{ $activeTab == 12 ? 'active' : '' }}" id="tab_12">
           @include('livewire.entrada.ver-entrada.tabs.tab-videos')
       </div>
    
    4. Crear el archivo: resources/views/livewire/entrada/ver-entrada/tabs/tab-videos.blade.php
       Con el siguiente contenido:
       
       <div class="card m-0" style="min-height: 65vh;">
           <div class="card-body">
               @livewire('video-recorder', [
                   'modelType' => 'App\\Models\\Entrada',
                   'modelId' => $entrada->id
               ])
           </div>
       </div>
--}}

{{-- 
    EJEMPLO 4: Uso programático desde un controlador o Livewire Component
    
    Para obtener los videos de un modelo:
--}}

{{-- 
<?php

use App\Models\Entrada;
use App\Models\Video;

// Obtener una entrada
$entrada = Entrada::find(1);

// Obtener todos los videos de la entrada
$videos = $entrada->videos;

// O usando la relación polimórfica directamente
$videos = Video::where('model_type', 'App\\Models\\Entrada')
    ->where('model_id', 1)
    ->get();

// Acceder a las propiedades del video
foreach ($videos as $video) {
    echo $video->complete_url; // URL completa del video
    echo $video->formatted_duration; // Duración formateada (mm:ss)
    echo $video->formatted_size; // Tamaño formateado (KB, MB, GB)
    echo $video->description; // Descripción del video
}

// Crear un video programáticamente
$video = Video::create([
    'model_type' => 'App\\Models\\Entrada',
    'model_id' => 1,
    'url' => 'videos/mi-video.mp4',
    'filename' => 'mi-video.mp4',
    'mime_type' => 'video/mp4',
    'size' => 1024000, // en bytes
    'duration' => 120, // en segundos
    'description' => 'Video de ejemplo',
]);
?>
--}}

{{-- 
    CONFIGURACIÓN PARA S3
    
    Cuando quieras migrar a S3, solo necesitas:
    
    1. Configurar tu .env:
       AWS_ACCESS_KEY_ID=your-key
       AWS_SECRET_ACCESS_KEY=your-secret
       AWS_DEFAULT_REGION=us-east-1
       AWS_BUCKET=your-bucket-name
       AWS_BUCKET_URL=https://your-bucket.s3.amazonaws.com
       
    2. Modificar el VideoController.php, cambiar:
       $path = $file->storeAs('videos', $filename, 'public');
       
       Por:
       $path = $file->storeAs('videos', $filename, 's3');
       
    3. En el modelo Video.php, la lógica ya está preparada para usar 
       AWS_BUCKET_URL del .env
--}}

{{-- 
    PERMISOS DE CÁMARA
    
    Para que funcione la grabación de video, el navegador necesita permisos
    para acceder a la cámara y micrófono. Asegúrate de:
    
    1. Usar HTTPS en producción (requerido por navegadores modernos)
    2. El usuario debe dar permiso cuando se le solicite
    3. Navegadores compatibles: Chrome, Firefox, Edge, Safari (iOS 14.3+)
--}}

{{-- 
    FORMATOS SOPORTADOS
    
    Grabación: WebM (codec VP9)
    Subida: MP4, MOV, AVI, WMV, FLV, WEBM
    Tamaño máximo: 100MB (configurable en VideoController)
--}}

