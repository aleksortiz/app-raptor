<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlComentario">
    <div class="modal-dialog modal-md">
        
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Comentario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Comentarios</label>
                        <textarea maxlength="255" rows="4" wire:model.lazy="comentario.mensaje" type="text" class="form-control"></textarea>
                        @error('comentario.mensaje') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="agregarComentario()" class="btn btn-primary"><i class="fas fa-comment"></i> Agregar</button>
                
            </div>
        </div>

    </div>
</div>