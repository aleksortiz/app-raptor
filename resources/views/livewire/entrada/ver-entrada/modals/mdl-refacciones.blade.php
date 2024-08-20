<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateRefaccion">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Refacción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Descripción</label>
                        <input wire:model.defer="refaccion.descripcion" type="text" class="form-control" />
                        @error('refaccion.descripcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group col-8">
                        <label>Número de Parte</label>
                        <input wire:model.defer="refaccion.numero_parte" type="text" class="form-control" style="text-transform: uppercase;" />
                        @error('refaccion.numero_parte')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label>Cantidad</label>
                        <input style="text-align: center;" wire:model.defer="refaccion.cantidad" type="text" class="form-control" />
                        @error('refaccion.cantidad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                      
                        <div class="form-group col-6">
                            <label>Costo</label>
                            <input style="text-align: right;" wire:model.defer="refaccion.costo" type="text" class="form-control" />
                            @error('refaccion.costo')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($this->entrada?->venta_refacciones)
                            <div class="form-group col-6">
                                <label>Precio</label>
                                <input style="text-align: right;" wire:model.defer="refaccion.precio" type="text" class="form-control" />
                                @error('refaccion.precio')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createRefaccion()" class="btn btn-primary"><i
                    class="fas fa-plus"></i> Agregar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
