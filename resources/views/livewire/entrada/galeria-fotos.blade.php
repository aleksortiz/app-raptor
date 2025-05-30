<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Galería de Fotos</h5>
            
            @if($entrada->fotos->count() > 0)
                <div class="row">
                    <!-- Main Photo Display -->
                    <div class="col-md-8 mb-4">
                        <div class="position-relative">
                            <img src="{{ $activePhoto ? $activePhoto->complete_url : $entrada->main_photo }}" 
                                class="img-fluid rounded shadow" 
                                style="width: 100%; height: 500px; object-fit: contain; background-color: #f8f9fa;"
                                alt="Foto principal">
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="col-md-4">
                        <div class="thumbnails-container" style="height: 500px; overflow-y: auto;">
                            <div class="row g-2">
                                @foreach($entrada->fotos as $foto)
                                    <div class="col-6">
                                        <div class="thumbnail-wrapper position-relative" 
                                             wire:click="setActivePhoto({{ $foto->id }})"
                                             style="cursor: pointer;">
                                            <img src="{{ $foto->complete_thumb_url }}" 
                                                class="img-fluid rounded {{ $activePhoto && $activePhoto->id == $foto->id ? 'border border-primary border-3' : 'border' }}"
                                                style="width: 100%; height: 100px; object-fit: cover;"
                                                alt="Miniatura {{ $loop->iteration }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo Information -->
                @if($activePhoto)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Subida el {{ \Carbon\Carbon::parse($activePhoto->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div>
                                <a href="{{ $activePhoto->complete_url }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Ver Tamaño Completo
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

            @else
                <div class="text-center py-5">
                    <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">No hay fotos disponibles para esta entrada</h6>
                </div>
            @endif
        </div>
    </div>

    <style>
        .thumbnails-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .thumbnails-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .thumbnails-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        
        .thumbnails-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</div> 