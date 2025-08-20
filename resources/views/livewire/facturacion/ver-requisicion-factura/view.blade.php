<div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Detalles de Requisición de Factura #{{ $requisicion->id ?? '' }}
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-secondary" wire:click="goBack">
                            <i class="fas fa-arrow-left"></i> Volver
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($requisicion)
    <div class="row">
        <!-- Columna de información principal -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información de la Requisición
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">ID Requisición</span>
                                    <span class="info-box-number text-bold">{{ $requisicion->id }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Cliente</span>
                                    <span class="info-box-number text-bold">{{ $requisicion->nombre_cliente }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Aseguradora</span>
                                    <span class="info-box-number text-bold">{{ $requisicion->aseguradora }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Monto</span>
                                    <span class="info-box-number text-bold">${{ number_format($requisicion->monto, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Uso CFDI</span>
                                    <span class="info-box-number text-bold">
                                        {{ $requisicion->uso_cfdi }} - {{ $usoCfdiOptions[$requisicion->uso_cfdi] ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Forma de Pago</span>
                                    <span class="info-box-number text-bold">
                                        {{ $requisicion->forma_pago }} - {{ $formasPagoOptions[$requisicion->forma_pago] ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Fecha de Creación</span>
                                    <span class="info-box-number text-bold">
                                        {{ \Carbon\Carbon::parse($requisicion->created_at)->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>
                            @if($entrada)
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">Entrada Relacionada</span>
                                    <span class="info-box-number text-bold">
                                        <a href="/servicios/{{ $entrada->id }}" target="_blank">
                                            <i class="fas fa-car"></i> {{ $entrada->folio }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-secondary">
                                    <h3 class="card-title">Descripción</h3>
                                </div>
                                <div class="card-body">
                                    <p class="lead">{{ $requisicion->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($entrada)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">
                                        <i class="fas fa-car mr-2"></i>
                                        Datos del Vehículo
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Marca:</strong> {{ $entrada->marca }}</p>
                                            <p><strong>Modelo:</strong> {{ $entrada->modelo }}</p>
                                            <p><strong>Año:</strong> {{ $entrada->year }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Color:</strong> {{ $entrada->color }}</p>
                                            <p><strong>Placas:</strong> {{ $entrada->placas }}</p>
                                            <p><strong>Serie:</strong> {{ $entrada->serie }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sección de Facturación y Pago -->
            <div class="card mt-4">
                <div class="card-header bg-success">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Datos de Facturación y Pago
                    </h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveFacturaPago">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número de Factura</label>
                                    <input type="text" class="form-control" wire:model.defer="numeroFactura" 
                                        {{ !empty($requisicion->numero_factura) ? 'disabled' : '' }}>
                                    @error('numeroFactura') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Pago</label>
                                    <input type="date" class="form-control" wire:model.defer="fechaPago" 
                                        {{ !empty($requisicion->fecha_pago) ? 'disabled' : '' }}>
                                    @error('fechaPago') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        @if(empty($requisicion->numero_factura) || empty($requisicion->fecha_pago))
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna de documentos -->
        <div class="col-md-4">
            <!-- Constancia Fiscal -->
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Constancia Fiscal
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if($constanciaUrl)
                        <div class="mb-3">
                            <a href="{{ $constanciaUrl }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-eye mr-1"></i> Ver Documento
                            </a>
                            <a href="{{ $constanciaUrl }}" download class="btn btn-secondary ml-2">
                                <i class="fas fa-download mr-1"></i> Descargar
                            </a>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $constanciaUrl }}" allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            No se ha cargado la constancia fiscal para este cliente.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documento INE (si existe entrada) -->
            @if($entrada)
            <div class="card mt-4">
                <div class="card-header bg-danger">
                    <h3 class="card-title">
                        <i class="fas fa-id-card mr-2"></i>
                        Identificación INE
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if($ineUrl)
                        <div class="mb-3">
                            <a href="{{ $ineUrl }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-eye mr-1"></i> Ver Documento
                            </a>
                            <a href="{{ $ineUrl }}" download class="btn btn-secondary ml-2">
                                <i class="fas fa-download mr-1"></i> Descargar
                            </a>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $ineUrl }}" allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            No se ha cargado la identificación INE para esta entrada.
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Orden de Admisión (si existe) -->
            @if($entrada)
            <div class="card mt-4">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-2"></i>
                        Orden de Admisión
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if($ordenAdmisionUrl)
                        <div class="mb-3">
                            <a href="{{ $ordenAdmisionUrl }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-eye mr-1"></i> Ver Documento
                            </a>
                            <a href="{{ $ordenAdmisionUrl }}" download class="btn btn-secondary ml-2">
                                <i class="fas fa-download mr-1"></i> Descargar
                            </a>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $ordenAdmisionUrl }}" allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            No se ha cargado la orden de admisión para esta entrada.
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-2"></i>
                No se ha encontrado la requisición solicitada.
            </div>
        </div>
    </div>
    @endif
</div>
