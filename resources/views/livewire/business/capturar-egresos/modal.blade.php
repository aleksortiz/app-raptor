<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registar {{$this->modelName}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="form-group col">
                        <label>Concepto</label>
                        <textarea class="form-control" wire:model.defer="model.concepto"></textarea>
                        @error('model.concepto') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        <label>Monto</label>
                        <input style="text-align: right;" wire:model.defer="model.monto" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                        @error('model.monto') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-6">
                        <label>Fecha</label>
                        <input wire:model.defer="model.fecha" type="datetime-local" class="form-control" />
                        @error('model.fecha') <span class="error text-danger">{{ $message }}</span> @enderror

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="save" class="btn btn-success"><i class="fas fa-check"></i> Aceptar</button>
            </div>
        </div>
    </div>
</div>