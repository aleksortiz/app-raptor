<div>
    <div wire:ignore.self class="modal fade" id="mdlEditarRefaccion" tabindex="-1" role="dialog" aria-labelledby="mdlEditarRefaccionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEditarRefaccionLabel">Editar Refacción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select wire:model="estado" id="estado" class="form-control">
                                <option value="ALMACEN">ALMACEN</option>
                                <option value="PENDIENTE">PENDIENTE</option>
                                <option value="VENTA">VENTA</option>
                                <option value="OTRO">OTRO</option>
                            </select>
                        </div>
                        @if($estado === 'VENTA')
                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <input type="number" step="0.01" wire:model="costo" id="costo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" wire:model="precio" id="precio" class="form-control">
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
