<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateVehiculoCuenta">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar vehículo a cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="form-group col-9">
                        <label>Vehículo</label>
                        <input wire:model.defer="vehiculoCuentaDescripcion" type="text" class="form-control" />
                        @error('vehiculoCuentaDescripcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-3">
                        <label>Monto</label>
                        <input style="text-align: right;" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.defer="vehiculoCuentaMonto" type="text" class="form-control" />
                        @error('vehiculoCuentaMonto')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        <label>Fecha</label>
                        <input wire:model.defer="vehiculoCuentaFecha" type="date" class="form-control" />
                        @error('vehiculoCuentaFecha')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-9">
                        <label>Vendedor</label>
                        <input wire:model.defer="vehiculoCuentaVendedor" type="text" class="form-control" />
                        @error('vehiculoCuentaVendedor')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label>Notas</label>
                        <textarea wire:model.defer="vehiculoCuentaNotas" class="form-control" style="resize: none;" rows="3" maxlength="255"></textarea>
                        @error('vehiculoCuentaNotas')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createVehiculoCuenta" class="btn btn-primary"><i class="fas fa-check"></i> Registrar</button>
            </div>
        </div>
        
    </div>
</div>
