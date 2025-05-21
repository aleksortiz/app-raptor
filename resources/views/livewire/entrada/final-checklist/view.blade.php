<div class="d-flex justify-content-center align-items-start" style="min-height: 100vh;">
    <div class="card my-4 w-100" style="max-width: 1200px;">
        <div class="card-header text-center">
            <h3 class="card-title" style="font-size: 2.2rem;">Checklist Final - {{ $entrada->folio_short }} / {{ $entrada->vehiculo }}</h3>
        </div>
        <div class="card-body px-4">
            <div class="alert alert-info mb-4 p-3" style="background-color: #17a2b8; color: #fff; display: flex; align-items: center;">
                <div style="flex-shrink:0; display: flex; align-items: center; justify-content: center; height: 100%;">
                    <i class="fas fa-info-circle" style="font-size: 2.5rem; margin-right: 1.2rem;"></i>
                </div>
                <div style="flex-grow:1;">
                    <h5 class="alert-heading mb-1" style="color: #fff; font-size: 1.3rem;">Revisión Completa del Vehículo</h5>
                    <p class="mb-0" style="color: #eaf6fa; font-size: 1.08rem;">Si ha realizado una revisión exhaustiva y todos los puntos cumplen con los estándares de calidad, puede marcar la siguiente opción:</p>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="d-flex align-items-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="masterAcceptance" wire:click="toggleMasterAcceptance" @if($masterAcceptance) checked @endif>
                        <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="masterAcceptance">
                            <strong>Confirmo que he realizado una revisión completa y exhaustiva del vehículo</strong>
                        </label>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="saveChecklist">
                <!-- Revisión General -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🛠️ 1. Revisión General de Carrocería</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="piezas_alineadas" wire:model="checklist.revision_general.piezas_alineadas.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="piezas_alineadas">{{ $checklist['revision_general']['piezas_alineadas']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_general', 'piezas_alineadas') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_general', 'piezas_alineadas')"
                                    style="display: {{ $checklist['revision_general']['piezas_alineadas']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="lineas_ensamble" wire:model="checklist.revision_general.lineas_ensamble.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="lineas_ensamble">{{ $checklist['revision_general']['lineas_ensamble']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_general', 'lineas_ensamble') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_general', 'lineas_ensamble')"
                                    style="display: {{ $checklist['revision_general']['lineas_ensamble']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_abolladuras" wire:model="checklist.revision_general.sin_abolladuras.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_abolladuras">{{ $checklist['revision_general']['sin_abolladuras']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_general', 'sin_abolladuras') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_general', 'sin_abolladuras')"
                                    style="display: {{ $checklist['revision_general']['sin_abolladuras']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_rayones" wire:model="checklist.revision_general.sin_rayones.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_rayones">{{ $checklist['revision_general']['sin_rayones']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_general', 'sin_rayones') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_general', 'sin_rayones')"
                                    style="display: {{ $checklist['revision_general']['sin_rayones']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_residuos" wire:model="checklist.revision_general.sin_residuos.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_residuos">{{ $checklist['revision_general']['sin_residuos']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_general', 'sin_residuos') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_general', 'sin_residuos')"
                                    style="display: {{ $checklist['revision_general']['sin_residuos']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Revisión de Pintura -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🎨 2. Revisión de Pintura</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="color_coincide" wire:model="checklist.revision_pintura.color_coincide.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="color_coincide">{{ $checklist['revision_pintura']['color_coincide']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_pintura', 'color_coincide') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_pintura', 'color_coincide')"
                                    style="display: {{ $checklist['revision_pintura']['color_coincide']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_diferencias_tono" wire:model="checklist.revision_pintura.sin_diferencias_tono.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_diferencias_tono">{{ $checklist['revision_pintura']['sin_diferencias_tono']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_pintura', 'sin_diferencias_tono') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_pintura', 'sin_diferencias_tono')"
                                    style="display: {{ $checklist['revision_pintura']['sin_diferencias_tono']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_escurrimientos" wire:model="checklist.revision_pintura.sin_escurrimientos.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_escurrimientos">{{ $checklist['revision_pintura']['sin_escurrimientos']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_pintura', 'sin_escurrimientos') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_pintura', 'sin_escurrimientos')"
                                    style="display: {{ $checklist['revision_pintura']['sin_escurrimientos']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_exceso_pintura" wire:model="checklist.revision_pintura.sin_exceso_pintura.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_exceso_pintura">{{ $checklist['revision_pintura']['sin_exceso_pintura']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_pintura', 'sin_exceso_pintura') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_pintura', 'sin_exceso_pintura')"
                                    style="display: {{ $checklist['revision_pintura']['sin_exceso_pintura']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="barniz_correcto" wire:model="checklist.revision_pintura.barniz_correcto.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="barniz_correcto">{{ $checklist['revision_pintura']['barniz_correcto']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('revision_pintura', 'barniz_correcto') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('revision_pintura', 'barniz_correcto')"
                                    style="display: {{ $checklist['revision_pintura']['barniz_correcto']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Limpieza -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🧼 3. Limpieza Exterior e Interior</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="vehiculo_lavado" wire:model="checklist.limpieza.vehiculo_lavado.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="vehiculo_lavado">{{ $checklist['limpieza']['vehiculo_lavado']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('limpieza', 'vehiculo_lavado') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('limpieza', 'vehiculo_lavado')"
                                    style="display: {{ $checklist['limpieza']['vehiculo_lavado']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_residuos_limpieza" wire:model="checklist.limpieza.sin_residuos.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_residuos_limpieza">{{ $checklist['limpieza']['sin_residuos']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('limpieza', 'sin_residuos') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('limpieza', 'sin_residuos')"
                                    style="display: {{ $checklist['limpieza']['sin_residuos']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sistema Eléctrico -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">💡 4. Sistema Eléctrico y Funcionalidades</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="luces_altas_bajas" wire:model="checklist.sistema_electrico.luces_altas_bajas.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="luces_altas_bajas">{{ $checklist['sistema_electrico']['luces_altas_bajas']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'luces_altas_bajas') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'luces_altas_bajas')"
                                    style="display: {{ $checklist['sistema_electrico']['luces_altas_bajas']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="direccionales" wire:model="checklist.sistema_electrico.direccionales.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="direccionales">{{ $checklist['sistema_electrico']['direccionales']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'direccionales') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'direccionales')"
                                    style="display: {{ $checklist['sistema_electrico']['direccionales']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="luces_freno_reversa" wire:model="checklist.sistema_electrico.luces_freno_reversa.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="luces_freno_reversa">{{ $checklist['sistema_electrico']['luces_freno_reversa']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'luces_freno_reversa') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'luces_freno_reversa')"
                                    style="display: {{ $checklist['sistema_electrico']['luces_freno_reversa']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="claxon" wire:model="checklist.sistema_electrico.claxon.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="claxon">{{ $checklist['sistema_electrico']['claxon']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'claxon') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'claxon')"
                                    style="display: {{ $checklist['sistema_electrico']['claxon']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="limpiaparabrisas" wire:model="checklist.sistema_electrico.limpiaparabrisas.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="limpiaparabrisas">{{ $checklist['sistema_electrico']['limpiaparabrisas']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'limpiaparabrisas') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'limpiaparabrisas')"
                                    style="display: {{ $checklist['sistema_electrico']['limpiaparabrisas']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="elevadores_seguros" wire:model="checklist.sistema_electrico.elevadores_seguros.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="elevadores_seguros">{{ $checklist['sistema_electrico']['elevadores_seguros']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'elevadores_seguros') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'elevadores_seguros')"
                                    style="display: {{ $checklist['sistema_electrico']['elevadores_seguros']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="aire_radio" wire:model="checklist.sistema_electrico.aire_radio.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="aire_radio">{{ $checklist['sistema_electrico']['aire_radio']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('sistema_electrico', 'aire_radio') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('sistema_electrico', 'aire_radio')"
                                    style="display: {{ $checklist['sistema_electrico']['aire_radio']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Testigos -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">⚠️ 5. Revisión de Testigos</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="abs" wire:model="checklist.testigos.abs.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="abs">{{ $checklist['testigos']['abs']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'abs') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'abs')"
                                    style="display: {{ $checklist['testigos']['abs']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="check_engine" wire:model="checklist.testigos.check_engine.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="check_engine">{{ $checklist['testigos']['check_engine']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'check_engine') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'check_engine')"
                                    style="display: {{ $checklist['testigos']['check_engine']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="antiderrapante" wire:model="checklist.testigos.antiderrapante.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="antiderrapante">{{ $checklist['testigos']['antiderrapante']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'antiderrapante') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'antiderrapante')"
                                    style="display: {{ $checklist['testigos']['antiderrapante']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="brake" wire:model="checklist.testigos.brake.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="brake">{{ $checklist['testigos']['brake']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'brake') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'brake')"
                                    style="display: {{ $checklist['testigos']['brake']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="bolsas" wire:model="checklist.testigos.bolsas.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="bolsas">{{ $checklist['testigos']['bolsas']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'bolsas') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'bolsas')"
                                    style="display: {{ $checklist['testigos']['bolsas']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="stability_track" wire:model="checklist.testigos.stability_track.checked">
                                <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="stability_track">{{ $checklist['testigos']['stability_track']['text'] }}</label>
                            </div>
                            <button type="button" class="btn btn-sm ml-2 {{ $this->hasComment('testigos', 'stability_track') ? 'btn-danger' : 'btn-outline-success' }}" 
                                    wire:click="openCommentModal('testigos', 'stability_track')"
                                    style="display: {{ $checklist['testigos']['stability_track']['checked'] ? 'inline-block' : 'none' }};">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Firma -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">✍️ 6. Firma de Verificación</h4>
                    <div class="form-group text-center">
                        <div class="signature-container" style="margin: 20px auto; max-width: 800px;">
                            <canvas id="drawingCanvas" width="800" height="300" style="border: 1px solid #ccc; border-radius: 4px;"></canvas>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary btn-lg" style="font-size: 1.2rem;" onclick="cleanCanvas()">
                                    <i class="fas fa-eraser"></i>
                                    Limpiar Firma
                                </button>
                                <button type="button" class="btn btn-success btn-lg" style="font-size: 1.2rem;" wire:click="guardarFirma">
                                    <i class="fas fa-check-circle"></i>
                                    ¡Vehículo Listo!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comment Modal -->
                @if($showCommentModal)
                <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Comentario</h5>
                                <button type="button" class="close" wire:click="$set('showCommentModal', false)">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <textarea class="form-control" wire:model="currentCommentText" rows="4" placeholder="Ingrese su comentario aquí..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showCommentModal', false)">Cancelar</button>
                                <button type="button" class="btn btn-primary" wire:click="saveComment">Guardar Comentario</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
                @endif
            </form>
        </div>
    </div>

    @push('js')
        <script>
            let hasSignature = false;

            document.addEventListener('DOMContentLoaded', function() {
                initCanvas();
            });

            Livewire.on('init-canvas', function(target) {
                initCanvas();
            });

            Livewire.on('guardar-firma', function(target) {
                if (!hasSignature) {
                    window.livewire.emit('info', 'Por favor firmar el checklist');
                    return;
                }
                const canvas = document.getElementById('drawingCanvas');
                const dataUrl = canvas.toDataURL('image/png');
                window.livewire.emit('saveSign', dataUrl);
            });

            function initCanvas() {
                const canvas = document.getElementById('drawingCanvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                canvas.height = 300;
                canvas.width = 800;

                // Variables para el dibujo
                let drawing = false;

                function startDrawing(e) {
                    e.preventDefault();
                    drawing = true;
                    draw(e);
                }

                function stopDrawing(e) {
                    e.preventDefault();
                    drawing = false;
                    ctx.beginPath();
                }

                function getEventPosition(e) {
                    const rect = canvas.getBoundingClientRect();
                    return {
                        x: e.clientX !== undefined ? e.clientX - rect.left : e.touches[0].clientX - rect.left,
                        y: e.clientY !== undefined ? e.clientY - rect.top : e.touches[0].clientY - rect.top
                    };
                }

                function draw(e) {
                    if (!drawing) return;

                    e.preventDefault();
                    ctx.lineWidth = 3;
                    ctx.lineCap = 'round';
                    ctx.strokeStyle = 'black';

                    const { x, y } = getEventPosition(e);

                    ctx.lineTo(x, y);
                    ctx.stroke();
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                    hasSignature = true;
                }

                // Event Listeners
                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseleave', stopDrawing);

                canvas.addEventListener('touchstart', startDrawing);
                canvas.addEventListener('touchend', stopDrawing);
                canvas.addEventListener('touchmove', draw);
            }

            function cleanCanvas() {
                const canvas = document.getElementById('drawingCanvas');
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                hasSignature = false;
                initCanvas();
            }
        </script>
    @endpush
</div>

<style>
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}
</style> 