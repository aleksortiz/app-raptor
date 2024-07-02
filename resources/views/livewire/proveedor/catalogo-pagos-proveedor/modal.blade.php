<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-7">
                        <label>Proveedor</label>
                        <input wire:model.defer="selectedProvider.nombre" readonly type="text" class="form-control" required />
                        @error('selectedProvider.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="ml-3 form-group col-3">
                        <label>Pago</label>
                        <input wire:model.defer="pagoMonto" wire:keydown.enter="registrarPago" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" required />
                        @error('pagoMonto') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="registrarPago" class="btn btn-success"><i class="fas fa-check"></i> Registrar Pago</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>