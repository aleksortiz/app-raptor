<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->ticket?->id ? 'Editar' : 'Agregar' }} Ticket de soporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col">
                            <label>Tipo</label>
                            <select wire:model="ticket.type" class="form-control form-control-sm" >
                                <option value=""></option>
                                <option value="GENERICO">GENERICO</option>
                                <option value="ERROR">ERROR / FALLA</option>
                                <option value="MODIFICACION">MODIFICACION</option>
                                <option value="COTIZACION">COTIZACION</option>
                            </select>
                            @error('ticket.type')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Requerimiento:</label>
                            <textarea wire:model.lazy="ticket.description" rows="8" class="form-control form-control-sm"></textarea>
                            @error('ticket.description')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                
                <div wire:loading.remove wire:target="save">
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                </div>
                <div wire:loading wire:target="save">
                    <button type="button" wire:click.prevent="save()" disabled class="btn btn-info"><i class="fas fa-spin fa-spinner"></i> Creando...</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
