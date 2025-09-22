@section('title', __('Generar Entrada'))

<div id="inventario-wizard" class="container-fluid">
    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" id="progress-bar" role="progressbar" style="width: 16.66%"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <small class="text-muted step-label active" data-step="1">Información General</small>
                <small class="text-muted step-label" data-step="2">Diagrama</small>
                <small class="text-muted step-label" data-step="3">Inventario</small>
                <small class="text-muted step-label" data-step="4">Testigos</small>
                <small class="text-muted step-label" data-step="5">Carrocería</small>
                <small class="text-muted step-label" data-step="6">Finalizar</small>
            </div>
        </div>
    </div>

    <!-- Cliente Info Header (Always visible) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-4">
                            <strong>Cliente:</strong> {{$this->cliente?->nombre}}
                        </div>
                        <div class="col-4">
                            <strong>Vehículo:</strong> {{$this->vehiculo}}
                        </div>
                        <div class="col-4">
                            <strong>Teléfono:</strong> {{$this->cliente?->telefono}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: Información General -->
    <div class="wizard-step" id="step-1">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Información General del Vehículo
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold" for="year">
                                <i class="fas fa-calendar me-1"></i>
                                Año
                            </label>
                            <input type="text" wire:model.defer="year" id="year" 
                                   class="form-control form-control-lg" maxlength="4" 
                                   placeholder="Año del vehículo" 
                                   onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                            @error('year') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold" for="kilometros">
                                <i class="fas fa-tachometer-alt me-1"></i>
                                Kilometraje
                            </label>
                            <input type="text" wire:model.defer="kilometros" id="kilometros" 
                                   class="form-control form-control-lg" 
                                   placeholder="Kilometraje actual" 
                                   onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                            @error('kilometros') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold" for="color">
                                <i class="fas fa-palette me-1"></i>
                                Color
                            </label>
                            <input type="text" wire:model.defer="color" id="color" 
                                   class="form-control form-control-lg" 
                                   style="text-transform: uppercase;" 
                                   placeholder="Color del vehículo">
                            @error('color') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold" for="placas">
                                <i class="fas fa-id-card me-1"></i>
                                Placas
                            </label>
                            <input type="text" wire:model.defer="placas" id="placas" 
                                   class="form-control form-control-lg" 
                                   style="text-transform: uppercase;" 
                                   placeholder="Número de placas">
                            @error('placas') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold" for="gasolina">
                                <i class="fas fa-gas-pump me-1"></i>
                                Nivel de Gasolina: <span id="gas-value">{{$this->gasolina ?? 0}}%</span>
                            </label>
                            <div wire:ignore>
                                <input id="range_gas" type="text" name="range_gas" value="">
                            </div>
                            @error('gasolina') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2: Diagrama -->
    <div class="wizard-step d-none" id="step-2">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    <i class="fas fa-draw-polygon me-2"></i>
                    Diagrama del Vehículo
                </h4>
            </div>
            <div class="card-body p-4 text-center">
                <p class="mb-4 text-muted">Dibuje las áreas dañadas directamente sobre el diagrama del vehículo</p>
                <div wire:ignore>
                    <canvas id="drawingCanvas" style="border: 2px solid #dee2e6; border-radius: 8px;"></canvas>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-secondary" onclick="cleanCanvas()">
                        <i class="fa fa-eraser me-1"></i> Limpiar Diagrama
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Inventario -->
    <div class="wizard-step d-none" id="step-3">
        @include('livewire.entrada.capturar-entrada-inventario.sections.inventario')
    </div>

    <!-- Step 4: Testigos -->
    <div class="wizard-step d-none" id="step-4">
        @include('livewire.entrada.capturar-entrada-inventario.sections.testigos-improved')
    </div>

    <!-- Step 5: Carrocería y Mecánica -->
    <div class="wizard-step d-none" id="step-5">
        @include('livewire.entrada.capturar-entrada-inventario.sections.carroceria-improved')
    </div>

    <!-- Step 6: Finalizar -->
    <div class="wizard-step d-none" id="step-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Finalizar Inventario
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="form-group">
                    <label class="form-label fw-semibold" for="notas">
                        <i class="fas fa-sticky-note me-1"></i>
                        Notas Adicionales
                    </label>
                    <textarea id="notas" wire:model.defer="notas" 
                              class="form-control form-control-lg" 
                              rows="5" 
                              placeholder="Agregue cualquier observación adicional sobre el inventario..."></textarea>
                    @error('notas') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
                <div class="mt-4 p-4 bg-light rounded">
                    <h5 class="text-success mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        Resumen del Inventario
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Vehículo:</strong> {{$this->vehiculo}}</li>
                                <li><strong>Año:</strong> <span id="summary-year">{{$this->year}}</span></li>
                                <li><strong>Color:</strong> <span id="summary-color">{{$this->color}}</span></li>
                                <li><strong>Placas:</strong> <span id="summary-placas">{{$this->placas}}</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Kilometraje:</strong> <span id="summary-km">{{$this->kilometros}}</span></li>
                                <li><strong>Gasolina:</strong> <span id="summary-gas">{{$this->gasolina}}%</span></li>
                                <li><strong>Cliente:</strong> {{$this->cliente?->nombre}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prev-btn" onclick="previousStep()" disabled>
                    <i class="fas fa-chevron-left me-1"></i> Anterior
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="next-btn" onclick="nextStep()">
                    Siguiente <i class="fas fa-chevron-right ms-1"></i>
                </button>
                <button type="button" class="btn btn-success btn-lg d-none" id="finish-btn" onclick="finishInventario()">
                    <i class="fas fa-check me-1"></i> Terminar Inventario
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.form-check-lg .form-check-input {
    width: 1.5rem;
    height: 1.5rem;
    margin-top: 0.125rem;
}

.form-check-lg .form-check-label {
    font-size: 1.1rem;
    padding-left: 0.5rem;
}

.step-label.active {
    color: #198754 !important;
    font-weight: 600;
}

.wizard-step {
    min-height: 400px;
}

.progress-bar {
    transition: width 0.3s ease;
}

@media (max-width: 768px) {
    .step-label {
        font-size: 0.75rem;
    }
}
</style>
