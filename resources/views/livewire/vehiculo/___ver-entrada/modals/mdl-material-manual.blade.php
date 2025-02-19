<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlMaterialManual">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Registro Manual (Material)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Descripción</label>
                        <input wire:model.defer="materialManual.descripcion" type="text" class="form-control" />
                        @error('materialManual.descripcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label>Cantidad</label>
                        <input style="text-align: center;" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.defer="materialManual.cantidad" type="text" class="form-control" />
                        @error('materialManual.cantidad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-4">
                        <label>Precio</label>
                        <input style="text-align: right;" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.defer="materialManual.precio" type="text" class="form-control" />
                        @error('materialManual.precio')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createMaterialManual()" class="btn btn-primary"><i
                    class="fas fa-plus"></i> Agregar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
