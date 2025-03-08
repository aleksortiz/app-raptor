<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSendMail">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar Correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Lista de Correos</label>
                        <textarea wire:model.defer="emailAddress" class="form-control" style="resize: none;" rows="4" maxlength="255"></textarea>
                        @error('emailAddress') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="sendMail" class="btn btn-success"><i class="fas fa-send"></i> Enviar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
