<div>
    <style>
        .photo-container {
            position: relative;
            overflow: hidden;
        }
        .photo-container img {
            transition: transform 0.3s ease;
        }
        .photo-container:hover img {
            transform: scale(1.05);
        }
        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .photo-container:hover .photo-overlay {
            opacity: 1;
        }
        .photo-overlay .btn {
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        .photo-container:hover .photo-overlay .btn {
            transform: scale(1);
        }
    </style>
    
    <div class="container-fluid p-3">
        <!-- Encabezado Simple -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <a href="/refacciones" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Regresar al Catálogo
                </a>
                <span class="mx-2 text-secondary">/</span>
                <h5 class="mb-0">{{ $refaccion->descripcion }}</h5>
            </div>
            <button class="btn btn-warning btn-sm" wire:click="showEdit">
                <i class="fas fa-edit mr-1"></i> Editar
            </button>
        </div>
    
        @livewire('refaccion.mdl-editar-refaccion', ['refaccion_id' => $refaccion->id], key('edit-'.$refaccion->id))
    
        <div class="row">
            <!-- Columna de Información -->
            <div class="col-md-3">
                <div class="card card-outline card-primary h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle text-primary"></i> Información
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-sm mb-0">
                            <tr>
                                <td class="text-muted">No. Parte</td>
                                <td class="text-right">{{ $refaccion->no_parte }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Proveedor</td>
                                <td class="text-right">{{ $refaccion->nombre_proveedor }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Estado</td>
                                <td class="text-right">
                                    <span class="badge {{ $refaccion->estado === 'PENDIENTE' ? 'badge-warning' : 'badge-success' }}">
                                        {{ $refaccion->estado }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Condición</td>
                                <td class="text-right">{{ $refaccion->condicion }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ubicación</td>
                                <td class="text-right">{{ $refaccion->ubicacion ?: 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
    
            <!-- Columna de Costos -->
            <div class="col-md-3">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-dollar-sign text-success"></i> Costos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Costo:</span>
                            <span class="h5 mb-0">${{ number_format($refaccion->costo, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Precio:</span>
                            <span class="h5 mb-0">${{ number_format($refaccion->precio, 2) }}</span>
                        </div>
                    </div>
                </div>
    
                @if($refaccion->notas)
                <div class="card card-outline card-warning mt-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sticky-note text-warning"></i> Notas
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">{{ $refaccion->notas }}</p>
                    </div>
                </div>
                @endif
            </div>
    
            <!-- Columna de Fotos -->
            <div class="col-md-6">
                <div class="card card-outline card-primary h-100" x-data="{ editMode: false }">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-images text-primary"></i> 
                            <span x-text="editMode ? 'Subir Fotos' : 'Galería'"></span>
                        </h3>
                        <div class="card-tools">
                            <button 
                                @click="editMode = !editMode"
                                class="btn btn-tool"
                                :class="{ 'text-primary': editMode }"
                            >
                                <i class="fas" :class="editMode ? 'fa-images' : 'fa-upload'"></i>
                            </button>
                        </div>
                    </div>
    
                    <div class="card-body p-2">
                        <div x-show="editMode" x-cloak>
                            @livewire('fotos.subir-fotos-v3', [
                                'model_id' => $refaccion->id,
                                'model_type' => get_class($refaccion),
                                'storage_path' => 'refacciones2/' . $refaccion->id
                            ], key('uploader-' . $refaccion->id))
                        </div>
    
                        <div x-show="!editMode" x-cloak>
                            @if($refaccion->fotos->count() > 0)
                                <div class="row row-cols-2 row-cols-md-3 g-2">
                                    @foreach($refaccion->fotos as $foto)
                                        <div class="col">
                                            <div class="position-relative photo-container">
                                                <img 
                                                    src="{{ $foto->url_thumb }}" 
                                                    alt="Foto de refacción" 
                                                    class="img-fluid rounded"
                                                    style="aspect-ratio: 16/9; object-fit: cover; width: 100%;"
                                                >
                                                <div class="photo-overlay">
                                                    <a 
                                                        href="{{ $foto->url }}" 
                                                        target="_blank"
                                                        class="btn btn-sm btn-light rounded-circle"
                                                    >
                                                        <i class="fas fa-expand"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-camera-retro text-secondary opacity-50 fa-2x mb-2"></i>
                                    <p class="text-muted small mb-0">No hay fotos disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>