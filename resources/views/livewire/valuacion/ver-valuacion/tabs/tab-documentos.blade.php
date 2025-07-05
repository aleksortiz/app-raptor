<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        <h4 class="text-center mb-4">Documentos de la Valuación</h4>
        
        <div class="row">
            <!-- ODA Document -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 {{ $this->hasDocument('ODA') ? 'border-success' : 'border-warning' }}">
                    <div class="card-header {{ $this->hasDocument('ODA') ? 'bg-success' : 'bg-warning' }} text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt mr-2"></i>Orden de Admisión (ODA)
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        @if($this->hasDocument('ODA'))
                            <div class="text-center mb-3">
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-check-circle mr-1"></i> Documento cargado
                                </span>
                                <p class="text-muted mt-2">
                                    <small>Subido: {{ $this->getDocumentDate('ODA') }}</small>
                                </p>
                            </div>
                            <div class="mt-auto">
                                <div class="btn-group w-100">
                                    <a href="{{ $this->getDocumentUrl('ODA') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>
                                    <button wire:click="deleteDocument('ODA')" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar este documento?')">
                                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center mb-3">
                                <span class="badge badge-warning p-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Documento pendiente
                                </span>
                            </div>
                            <div class="mt-auto">
                                <a href="aosscan:Valuacion#{{$this->valuacion?->id}}#ODA" class="btn btn-warning btn-block">
                                    <i class="fas fa-file-upload mr-2"></i>Subir Documento
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- INE Document -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 {{ $this->hasDocument('INE') ? 'border-success' : 'border-warning' }}">
                    <div class="card-header {{ $this->hasDocument('INE') ? 'bg-success' : 'bg-warning' }} text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card mr-2"></i>Identificación (INE)
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        @if($this->hasDocument('INE'))
                            <div class="text-center mb-3">
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-check-circle mr-1"></i> Documento cargado
                                </span>
                                <p class="text-muted mt-2">
                                    <small>Subido: {{ $this->getDocumentDate('INE') }}</small>
                                </p>
                            </div>
                            <div class="mt-auto">
                                <div class="btn-group w-100">
                                    <a href="{{ $this->getDocumentUrl('INE') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>
                                    <button wire:click="deleteDocument('INE')" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar este documento?')">
                                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center mb-3">
                                <span class="badge badge-warning p-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Documento pendiente
                                </span>
                            </div>
                            <div class="mt-auto">
                                <a href="aosscan:Valuacion#{{$this->valuacion?->id}}#INE" class="btn btn-warning btn-block">
                                    <i class="fas fa-file-upload mr-2"></i>Subir Documento
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>