<div class="card shadow-sm">
    <div class="card-header bg-gradient-danger text-white">
        <h4 class="mb-0 d-flex align-items-center">
            <div class="me-3 p-2 bg-white bg-opacity-20 rounded-circle">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
            </div>
            <div>
                <span class="fw-bold">Testigos del Tablero</span>
                <small class="d-block opacity-75">Marque las luces de advertencia que están encendidas</small>
            </div>
        </h4>
    </div>
    
    <div class="card-body p-4">
        <!-- Primera fila: 3 testigos -->
        <div class="row justify-content-center mb-4">
            <!-- ABS -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="abs">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="abs" id="abs">
                        <label class="form-check-label testigo-label w-100" for="abs">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-primary">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">ABS</h6>
                                    <small class="testigo-description">Sistema Antibloqueo de Frenos</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Check Engine -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="check_engine">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="check_engine" id="check_engine">
                        <label class="form-check-label testigo-label w-100" for="check_engine">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-warning">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">Check Engine</h6>
                                    <small class="testigo-description">Falla en el Sistema del Motor</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Antiderrapante -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="antiderrapante">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="antiderrapante" id="antiderrapante">
                        <label class="form-check-label testigo-label w-100" for="antiderrapante">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-success">
                                    <i class="fas fa-road"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">Antiderrapante</h6>
                                    <small class="testigo-description">Control de Tracción</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: 3 testigos -->
        <div class="row justify-content-center">
            <!-- Brake -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="brake">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="brake" id="brake">
                        <label class="form-check-label testigo-label w-100" for="brake">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-danger">
                                    <i class="fas fa-hand-paper"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">Brake</h6>
                                    <small class="testigo-description">Sistema de Frenos</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Bolsas de Aire -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="bolsas">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="bolsas" id="bolsas">
                        <label class="form-check-label testigo-label w-100" for="bolsas">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-info">
                                    <i class="fas fa-life-ring"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">Airbags</h6>
                                    <small class="testigo-description">Bolsas de Aire</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Stability Track -->
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="testigo-card" data-testigo="stability_track">
                    <div class="form-check form-check-lg position-relative">
                        <input class="form-check-input testigo-input" type="checkbox" wire:model.defer="stability_track" id="stability_track">
                        <label class="form-check-label testigo-label w-100" for="stability_track">
                            <div class="testigo-content">
                                <div class="testigo-icon bg-secondary">
                                    <i class="fas fa-car-side"></i>
                                </div>
                                <div class="testigo-info">
                                    <h6 class="testigo-title mb-1">Stability Track</h6>
                                    <small class="testigo-description">Control de Estabilidad</small>
                                </div>
                                <div class="testigo-status">
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="mt-4 p-3 bg-light rounded-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle text-primary me-2"></i>
                <small class="text-muted mb-0">
                    <strong>Nota:</strong> Marque únicamente los testigos que están encendidos o parpadeando en el tablero del vehículo.
                </small>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para la sección de testigos mejorada */
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.testigo-card {
    height: 100%;
    transition: all 0.3s ease;
}

.testigo-card:hover {
    transform: translateY(-2px);
}

.testigo-label {
    cursor: pointer;
    margin-bottom: 0;
    padding: 0;
}

.testigo-content {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    background: white;
    transition: all 0.3s ease;
    min-height: 80px;
}

.testigo-content:hover {
    border-color: #adb5bd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.testigo-input:checked + .testigo-label .testigo-content {
    border-color: #198754;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);
    box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2);
}

.testigo-input:checked + .testigo-label .testigo-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.testigo-input:checked + .testigo-label .status-indicator {
    background: #198754;
    animation: pulse-green 2s infinite;
}

.testigo-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-right: 1rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.testigo-info {
    flex: 1;
    min-width: 0;
}

.testigo-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
}

.testigo-description {
    color: #6c757d;
    font-size: 0.85rem;
    line-height: 1.2;
}

.testigo-status {
    margin-left: 1rem;
    flex-shrink: 0;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    transition: all 0.3s ease;
}

.testigo-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

/* Animaciones */
@keyframes pulse-green {
    0% {
        box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(25, 135, 84, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(25, 135, 84, 0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .testigo-content {
        padding: 0.75rem;
        min-height: 70px;
    }
    
    .testigo-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-right: 0.75rem;
    }
    
    .testigo-title {
        font-size: 0.9rem;
    }
    
    .testigo-description {
        font-size: 0.8rem;
    }
}
</style>
