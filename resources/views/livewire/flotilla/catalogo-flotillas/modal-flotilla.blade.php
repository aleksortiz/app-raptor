<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCrearFlotilla">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Flotilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="vehiculo" wire:model="nombreFlotilla">
                    @error('nombreFlotilla') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Notas</label>
                    <textarea class="form-control" id="notas" wire:model="notasFlotilla"></textarea>
                    @error('notasFlotilla') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="createFlotilla" type="button" class="btn btn-success"><i class="fas fa-check"></i> Crear Flotilla</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>