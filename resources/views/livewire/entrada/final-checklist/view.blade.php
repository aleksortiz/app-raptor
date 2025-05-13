<div>
    <div class="card my-4" style="margin-left: auto; max-width: 1200px;">
        <div class="card-header text-center">
            <h3 class="card-title" style="font-size: 2.2rem;">Checklist Final - {{ $entrada->folio_short }} / {{ $entrada->vehiculo }}</h3>
        </div>
        <div class="card-body px-4">
            <form wire:submit.prevent="saveChecklist">
                <!-- Revisión General -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🛠️ 1. Revisión General de Carrocería</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="piezas_alineadas" wire:model="checklist.revision_general.piezas_alineadas">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="piezas_alineadas">Todas las piezas están bien alineadas (cofres, puertas, fascias, etc.)</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="lineas_ensamble" wire:model="checklist.revision_general.lineas_ensamble">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="lineas_ensamble">Las líneas de ensamble son uniformes</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_abolladuras" wire:model="checklist.revision_general.sin_abolladuras">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_abolladuras">No hay abolladuras visibles</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_rayones" wire:model="checklist.revision_general.sin_rayones">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_rayones">No hay rayones ni imperfecciones en superficies reparadas</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_residuos" wire:model="checklist.revision_general.sin_residuos">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_residuos">No hay restos de polvo o residuos de lijado o pintura</label>
                        </div>
                    </div>
                </div>

                <!-- Revisión de Pintura -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🎨 2. Revisión de Pintura</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="color_coincide" wire:model="checklist.revision_pintura.color_coincide">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="color_coincide">El color coincide con el resto del vehículo</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_diferencias_tono" wire:model="checklist.revision_pintura.sin_diferencias_tono">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_diferencias_tono">No hay diferencia de tono entre partes reparadas y originales</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_escurrimientos" wire:model="checklist.revision_pintura.sin_escurrimientos">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_escurrimientos">No hay escurrimientos, burbujas o piel de naranja</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_exceso_pintura" wire:model="checklist.revision_pintura.sin_exceso_pintura">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_exceso_pintura">No hay exceso de pintura en molduras, empaques o cristales</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="barniz_correcto" wire:model="checklist.revision_pintura.barniz_correcto">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="barniz_correcto">Se aplicó barniz correctamente</label>
                        </div>
                    </div>
                </div>

                <!-- Limpieza -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">🧼 3. Limpieza Exterior e Interior</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="vehiculo_lavado" wire:model="checklist.limpieza.vehiculo_lavado">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="vehiculo_lavado">Vehículo lavado completamente</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="sin_residuos_limpieza" wire:model="checklist.limpieza.sin_residuos">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="sin_residuos_limpieza">Se eliminaron residuos de masilla, polish o compuestos de pulido</label>
                        </div>
                    </div>
                </div>

                <!-- Sistema Eléctrico -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">💡 4. Sistema Eléctrico y Funcionalidades</h4>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="luces_altas_bajas" wire:model="checklist.sistema_electrico.luces_altas_bajas">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="luces_altas_bajas">Luces altas y bajas funcionando correctamente</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="direccionales" wire:model="checklist.sistema_electrico.direccionales">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="direccionales">Direccionales delanteras y traseras funcionando</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="luces_freno_reversa" wire:model="checklist.sistema_electrico.luces_freno_reversa">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="luces_freno_reversa">Luces de freno y de reversa funcionando</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="claxon" wire:model="checklist.sistema_electrico.claxon">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="claxon">Claxon en funcionamiento</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="limpiaparabrisas" wire:model="checklist.sistema_electrico.limpiaparabrisas">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="limpiaparabrisas">Limpiaparabrisas (wipers) funcionando correctamente</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="elevadores_seguros" wire:model="checklist.sistema_electrico.elevadores_seguros">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="elevadores_seguros">Elevadores eléctricos y seguros de puertas operan bien</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input custom-control-input-success" style="width: 3rem; height: 3rem;" id="aire_radio" wire:model="checklist.sistema_electrico.aire_radio">
                            <label class="custom-control-label" style="font-size: 1.5rem; padding-left: 0.8rem;" for="aire_radio">Aire acondicionado y radio funcionando correctamente</label>
                        </div>
                    </div>
                </div>

                <!-- Firma -->
                <div class="section mb-4 px-3">
                    <h4 class="mb-3 text-center" style="font-size: 1.6rem;">✍️ 5. Firma de Verificación</h4>
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

                {{-- <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" style="font-size: 1.5rem;">Guardar Checklist</button>
                </div> --}}
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