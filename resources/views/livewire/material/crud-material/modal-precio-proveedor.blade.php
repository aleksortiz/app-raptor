<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPrecioProveedor">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">MODAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>     
                <button type="button" wire:click="savePrecioMaterial" class="btn btn-success"><i class="fas fa-dollar-sign"></i> Aceptar</button>           
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>