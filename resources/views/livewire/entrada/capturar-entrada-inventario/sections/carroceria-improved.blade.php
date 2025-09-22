<div class="row g-4">
    <!-- Sección Carrocería -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0 d-flex align-items-center">
                    <div class="me-3 p-2 bg-white bg-opacity-20 rounded-circle">
                        <i class="fas fa-car fa-lg"></i>
                    </div>
                    <div>
                        <span class="fw-bold">Estado de Carrocería</span>
                        <small class="d-block opacity-75">Marque las áreas con daños visibles</small>
                    </div>
                </h5>
            </div>
            
            <div class="card-body p-4">
                <!-- Puertas -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#selectPuertas" wire:model.defer="puertas" id="puertas">
                            <label class="form-check-label damage-label" for="puertas">
                                <div class="damage-content">
                                    <div class="damage-icon bg-primary">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Puertas</h6>
                                        <small class="damage-description">Daños en puertas del vehículo</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="selectPuertas" class="damage-suboptions d-none mt-3">
                            <div class="suboption-grid">
                                <div class="suboption-item">
                                    <input type="checkbox" id="puertas_1" wire:model.defer="puertas_1" class="suboption-checkbox">
                                    <label for="puertas_1" class="suboption-label">
                                        <span class="suboption-number">1</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="puertas_2" wire:model.defer="puertas_2" class="suboption-checkbox">
                                    <label for="puertas_2" class="suboption-label">
                                        <span class="suboption-number">2</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="puertas_3" wire:model.defer="puertas_3" class="suboption-checkbox">
                                    <label for="puertas_3" class="suboption-label">
                                        <span class="suboption-number">3</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="puertas_4" wire:model.defer="puertas_4" class="suboption-checkbox">
                                    <label for="puertas_4" class="suboption-label">
                                        <span class="suboption-number">4</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="puertas_5" wire:model.defer="puertas_5" class="suboption-checkbox">
                                    <label for="puertas_5" class="suboption-label">
                                        <span class="suboption-number">5</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Costados -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#selectCostados" wire:model.defer="costados" id="costados">
                            <label class="form-check-label damage-label" for="costados">
                                <div class="damage-content">
                                    <div class="damage-icon bg-info">
                                        <i class="fas fa-arrows-alt-h"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Costados</h6>
                                        <small class="damage-description">Laterales del vehículo</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="selectCostados" class="damage-suboptions d-none mt-3">
                            <div class="suboption-grid">
                                <div class="suboption-item">
                                    <input type="checkbox" id="costados_izquierdo" wire:model.defer="costados_izquierdo" class="suboption-checkbox">
                                    <label for="costados_izquierdo" class="suboption-label">
                                        <i class="fas fa-arrow-left"></i>
                                        <span>Izquierdo</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="costados_derecho" wire:model.defer="costados_derecho" class="suboption-checkbox">
                                    <label for="costados_derecho" class="suboption-label">
                                        <i class="fas fa-arrow-right"></i>
                                        <span>Derecho</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Elementos individuales -->
                <div class="damage-grid">
                    <!-- Piso Cajuela -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="piso_cajuela" id="piso_cajuela">
                            <label class="form-check-label damage-simple-label" for="piso_cajuela">
                                <div class="damage-simple-content">
                                    <i class="fas fa-archive text-secondary"></i>
                                    <span>Piso Cajuela</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Tolva Escape -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="tolva_escape" id="tolva_escape">
                            <label class="form-check-label damage-simple-label" for="tolva_escape">
                                <div class="damage-simple-content">
                                    <i class="fas fa-wind text-primary"></i>
                                    <span>Tolva Escape</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Capacete -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="capacete" id="capacete">
                            <label class="form-check-label damage-simple-label" for="capacete">
                                <div class="damage-simple-content">
                                    <i class="fas fa-hard-hat text-warning"></i>
                                    <span>Capacete</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Cofre -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="cofre" id="cofre">
                            <label class="form-check-label damage-simple-label" for="cofre">
                                <div class="damage-simple-content">
                                    <i class="fas fa-car-side text-success"></i>
                                    <span>Cofre</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Rep Granizo -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="rep_granizo" id="rep_granizo">
                            <label class="form-check-label damage-simple-label" for="rep_granizo">
                                <div class="damage-simple-content">
                                    <i class="fas fa-cloud-hail text-info"></i>
                                    <span>Rep. Granizo</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Pintura General -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="pintura_general" id="pintura_general">
                            <label class="form-check-label damage-simple-label" for="pintura_general">
                                <div class="damage-simple-content">
                                    <i class="fas fa-paint-brush text-danger"></i>
                                    <span>Pintura General</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Fender -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#selectFender" wire:model.defer="fender" id="fender">
                            <label class="form-check-label damage-label" for="fender">
                                <div class="damage-content">
                                    <div class="damage-icon bg-warning">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Fender</h6>
                                        <small class="damage-description">Guardabarros del vehículo</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="selectFender" class="damage-suboptions d-none mt-3">
                            <div class="suboption-grid">
                                <div class="suboption-item">
                                    <input type="checkbox" id="fender_izquierdo" wire:model.defer="fender_izquierdo" class="suboption-checkbox">
                                    <label for="fender_izquierdo" class="suboption-label">
                                        <i class="fas fa-arrow-left"></i>
                                        <span>Izquierdo</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="fender_derecho" wire:model.defer="fender_derecho" class="suboption-checkbox">
                                    <label for="fender_derecho" class="suboption-label">
                                        <i class="fas fa-arrow-right"></i>
                                        <span>Derecho</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facia -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#selectFacia" wire:model.defer="facia" id="facia">
                            <label class="form-check-label damage-label" for="facia">
                                <div class="damage-content">
                                    <div class="damage-icon bg-success">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Facia</h6>
                                        <small class="damage-description">Fascia delantera y trasera</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="selectFacia" class="damage-suboptions d-none mt-3">
                            <div class="suboption-grid">
                                <div class="suboption-item">
                                    <input type="checkbox" id="facia_delantera" wire:model.defer="facia_delantera" class="suboption-checkbox">
                                    <label for="facia_delantera" class="suboption-label">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Delantera</span>
                                    </label>
                                </div>
                                <div class="suboption-item">
                                    <input type="checkbox" id="facia_trasera" wire:model.defer="facia_trasera" class="suboption-checkbox">
                                    <label for="facia_trasera" class="suboption-label">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Trasera</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Otro (Carrocería) -->
                <div class="damage-section">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#carroceria_otro_section" wire:model.defer="carroceria_otro" id="carroceria_otro">
                            <label class="form-check-label damage-label" for="carroceria_otro">
                                <div class="damage-content">
                                    <div class="damage-icon bg-secondary">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Otro</h6>
                                        <small class="damage-description">Especificar otro daño</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="carroceria_otro_section" class="damage-suboptions d-none mt-3">
                            <div class="form-group">
                                <input type="text" wire:model.defer="carroceria_otro_text" class="form-control form-control-lg" placeholder="Especifique el daño en carrocería...">
                                @error('carroceria_otro_text') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Mecánica -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-gradient-warning text-dark">
                <h5 class="mb-0 d-flex align-items-center">
                    <div class="me-3 p-2 bg-white bg-opacity-20 rounded-circle">
                        <i class="fas fa-cogs fa-lg"></i>
                    </div>
                    <div>
                        <span class="fw-bold">Estado Mecánico</span>
                        <small class="d-block opacity-75">Marque los problemas mecánicos detectados</small>
                    </div>
                </h5>
            </div>
            
            <div class="card-body p-4">
                <!-- Elementos mecánicos individuales -->
                <div class="damage-grid mb-4">
                    <!-- Afinación Mayor -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="afinacion_mayor" id="afinacion_mayor">
                            <label class="form-check-label damage-simple-label" for="afinacion_mayor">
                                <div class="damage-simple-content">
                                    <i class="fas fa-wrench text-primary"></i>
                                    <span>Afinación Mayor</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Cambio de Aceite -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="cambio_aceite" id="cambio_aceite">
                            <label class="form-check-label damage-simple-label" for="cambio_aceite">
                                <div class="damage-simple-content">
                                    <i class="fas fa-oil-can text-warning"></i>
                                    <span>Cambio de Aceite</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Frenos -->
                    <div class="damage-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.defer="frenos" id="frenos">
                            <label class="form-check-label damage-simple-label" for="frenos">
                                <div class="damage-simple-content">
                                    <i class="fas fa-stop-circle text-danger"></i>
                                    <span>Frenos</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Falla Mecánica -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#falla_mecanica_section" wire:model.defer="falla_mecanica" id="falla_mecanica">
                            <label class="form-check-label damage-label" for="falla_mecanica">
                                <div class="damage-content">
                                    <div class="damage-icon bg-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Falla Mecánica</h6>
                                        <small class="damage-description">Problema mecánico específico</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="falla_mecanica_section" class="damage-suboptions d-none mt-3">
                            <div class="form-group">
                                <input type="text" wire:model.defer="falla_mecanica_text" class="form-control form-control-lg" placeholder="Describa la falla mecánica...">
                                @error('falla_mecanica_text') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suspensión -->
                <div class="damage-section mb-4">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#suspension_section" wire:model.defer="suspension" id="suspension">
                            <label class="form-check-label damage-label" for="suspension">
                                <div class="damage-content">
                                    <div class="damage-icon bg-info">
                                        <i class="fas fa-car-crash"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Suspensión</h6>
                                        <small class="damage-description">Problemas en suspensión</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="suspension_section" class="damage-suboptions d-none mt-3">
                            <div class="form-group">
                                <input type="text" wire:model.defer="suspension_text" class="form-control form-control-lg" placeholder="Especifique el problema de suspensión...">
                                @error('suspension_text') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Otro (Mecánica) -->
                <div class="damage-section">
                    <div class="damage-item-main">
                        <div class="form-check form-check-lg">
                            <input class="form-check-input damage-checkbox" type="checkbox" data-target="#mecanica_otro_text_section" wire:model.defer="mecanica_otro" id="mecanica_otro">
                            <label class="form-check-label damage-label" for="mecanica_otro">
                                <div class="damage-content">
                                    <div class="damage-icon bg-secondary">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <div class="damage-info">
                                        <h6 class="damage-title">Otro</h6>
                                        <small class="damage-description">Especificar otro problema</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div id="mecanica_otro_text_section" class="damage-suboptions d-none mt-3">
                            <div class="form-group">
                                <input type="text" wire:model.defer="mecanica_otro_text" class="form-control form-control-lg" placeholder="Especifique el problema mecánico...">
                                @error('mecanica_otro_text') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para carrocería y mecánica mejorados */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.damage-section {
    margin-bottom: 1.5rem;
}

.damage-item-main {
    position: relative;
}

.damage-content {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    background: white;
    transition: all 0.3s ease;
    cursor: pointer;
}

.damage-content:hover {
    border-color: #adb5bd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.damage-checkbox:checked + .damage-label .damage-content {
    border-color: #198754;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);
    box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2);
}

.damage-icon {
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

.damage-checkbox:checked + .damage-label .damage-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.damage-info {
    flex: 1;
}

.damage-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.damage-description {
    color: #6c757d;
    font-size: 0.85rem;
}

.damage-label {
    cursor: pointer;
    margin-bottom: 0;
    width: 100%;
}

.damage-checkbox {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

/* Subopciones */
.damage-suboptions {
    margin-left: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #198754;
}

.suboption-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.suboption-item {
    position: relative;
}

.suboption-checkbox {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.suboption-label {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
}

.suboption-label:hover {
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.suboption-checkbox:checked + .suboption-label {
    background: #198754;
    color: white;
    border-color: #198754;
    transform: scale(1.05);
}

.suboption-number {
    width: 24px;
    height: 24px;
    background: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
}

.suboption-checkbox:checked + .suboption-label .suboption-number {
    background: rgba(255,255,255,0.2);
    color: white;
}

.suboption-label i {
    margin-right: 0.5rem;
}

/* Elementos simples */
.damage-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.damage-simple-label {
    cursor: pointer;
    margin-bottom: 0;
    width: 100%;
}

.damage-simple-content {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
}

.damage-simple-content:hover {
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.form-check-input:checked + .damage-simple-label .damage-simple-content {
    border-color: #198754;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);
}

.damage-simple-content i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.damage-simple-content span {
    font-weight: 500;
    color: #2c3e50;
}

/* Responsive */
@media (max-width: 768px) {
    .damage-content {
        padding: 0.75rem;
    }
    
    .damage-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-right: 0.75rem;
    }
    
    .damage-title {
        font-size: 0.9rem;
    }
    
    .damage-description {
        font-size: 0.8rem;
    }
    
    .suboption-grid {
        gap: 0.5rem;
    }
    
    .suboption-label {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .damage-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
}

/* Animaciones */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.damage-suboptions:not(.d-none) {
    animation: slideDown 0.3s ease;
}
</style>
