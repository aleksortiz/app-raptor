<!-- Modal para crear Cita de Reparación -->
<div wire:ignore.self class="modal fade" id="modalCitaReparacion" tabindex="-1" role="dialog" aria-labelledby="modalCitaReparacionLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCitaReparacionLabel">Crear Cita de Reparación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="cancelar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="guardarCitaReparacion">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" class="form-control" id="marca" wire:model="marca" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" class="form-control" id="modelo" wire:model="modelo" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="noReporte">Número de Reporte</label>
                        <input type="text" class="form-control" id="noReporte" wire:model="noReporte" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="fechaCita">Fecha y Hora de Cita</label>
                        <input type="datetime-local" class="form-control" id="fechaCita" wire:model="fechaCita">
                        @error('fechaCita') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancelar">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarCitaReparacion">Guardar</button>
            </div>
        </div>
    </div>
</div> 