<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateComment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Comentario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col">
                            <label>Comentario:</label>
                            <textarea wire:model.lazy="comment.comment" rows="4" class="form-control form-control-sm"></textarea>
                            @error('comment.comment')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <div wire:loading.remove wire:target="createComment">
                    <button type="button" wire:click.prevent="createComment" class="btn btn-success"><i class="fas fa-comment"></i> Aceptar</button>
                </div>
                <div wire:loading wire:target="createComment">
                    <button type="button" wire:click.prevent="createComment" class="btn btn-info" disabled><i class="fas fa-spin fa-spinner"></i> Enviando...</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
