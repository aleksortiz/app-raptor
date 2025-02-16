<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateGasto">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Gasto</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Concepto</label>
                        <input wire:model.defer="gastoConcepto" type="text" class="form-control" />
                        @error('gastoConcepto')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label>Monto</label>
                        <input style="text-align: right;" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.defer="gastoMonto" type="text" class="form-control" />
                        @error('gastoMonto')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createGasto" class="btn btn-primary"><i
                    class="fas fa-check"></i> Registrar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
