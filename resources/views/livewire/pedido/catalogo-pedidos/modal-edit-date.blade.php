<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlFechaPago">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fecha de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <button wire:click="removeDate" class="btn btn-danger btn-xs mr-1"><i class="fas fa-times"></i></button>
                        <label>Fecha de Pago</label>
                        <input wire:model.defer="selectedPedido.pagado" type="datetime-local" class="form-control" />
                        @error('selectedPedido.pagado') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="saveDate" class="btn btn-primary"><i
                    class="fas fa-save"></i> Guardar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
