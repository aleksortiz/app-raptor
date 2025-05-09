<div wire:ignore.self class="modal fade" id="mdlProyeccionEntrega" tabindex="-1" role="dialog" aria-labelledby="mdlProyeccionEntregaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlProyeccionEntregaLabel">Editar Fecha de Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <button wire:click="removeProyeccion" class="btn btn-danger btn-xs mr-1"><i class="fas fa-times"></i></button>
                    <label for="proyeccionFecha">Fecha de Entrega</label>
                    <input type="date" class="form-control" id="proyeccionFecha" wire:model="proyeccionFecha">
                    @error('proyeccionFecha') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cancelProyeccion">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="saveProyeccion">Guardar</button>
            </div>
        </div>
    </div>
</div>