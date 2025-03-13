<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar Factura</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="numero_factura">Número de Factura</label>
                            <input placeholder="Número de Factura"  type="text" class="form-control" id="numero_factura" wire:model="numero_factura">
                            @error('numero_factura') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input placeholder="Monto" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right" type="text" class="form-control" id="monto" wire:model="monto">
                            @error('monto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago</label>
                            <input placeholder="Fecha" type="date" class="form-control" id="fecha_pago" wire:model="fecha_pago">
                            @error('fecha_pago') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="notas">Notas</label>
                            <textarea style="resize: none" maxlength="255" placeholder="Notas" class="form-control" id="notas" wire:model="notas"></textarea>
                            @error('notas') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click="registrar"><i class="fas fa-check"></i> Registrar</button>

            </div>
        </div>
    </div>
</div>
