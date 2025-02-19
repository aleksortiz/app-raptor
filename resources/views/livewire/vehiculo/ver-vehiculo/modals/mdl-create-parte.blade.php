<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateParte">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Parte / Refacción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="form-group col-12">
                        <label>Descripción</label>
                        <textarea wire:model.defer="parteDescripcion" class="form-control" style="resize: none;" rows="3" maxlength="255"></textarea>
                        @error('parteDescripcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-8">
                        <label>Numero de Parte</label>
                        <input wire:model.defer="parteNumero" type="text" class="form-control" />
                        @error('parteNumero')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-3">
                        <label>Cantidad</label>
                        <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model.defer="parteCantidad" type="text" class="form-control" />
                        @error('parteCantidad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label>Costo Unitario</label>
                        <input style="text-align: right;" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.defer="parteCosto" type="text" class="form-control" />
                        @error('parteCosto')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-8">
                        <label>Fecha de Operación</label>
                        <input wire:model.defer="parteFecha" type="date" class="form-control" />
                        @error('parteFecha')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createParte" class="btn btn-primary"><i class="fas fa-check"></i> Registrar</button>
            </div>
        </div>
        
    </div>
</div>
