<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlGasto">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="gastoDescripcion">Descripción</label>
                    <input type="text" wire:model="gastoDescripcion" class="form-control" id="gastoDescripcion" placeholder="Descripción">
                    @error('gastoDescripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="gastoMonto">Monto</label>
                    <input style="width: 30%;" type="text" wire:model="gastoMonto" class="form-control" id="gastoMonto" placeholder="Monto">
                    @error('gastoMonto') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="recurrente">Gasto Recurrente</label>
                    <input type="checkbox" wire:model.defer="recurrente" id="recurrente">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" wire:click="guardarGasto" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
