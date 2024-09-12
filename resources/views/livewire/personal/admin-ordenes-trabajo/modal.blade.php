<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Orden de trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Nombre</label>
                            <input wire:model.defer="model.nombre" type="text" class="form-control" required />
                            @error('model.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-1">
                            <label class="" for="iptDestajo">Destajo</label>
                            <x-input-checkbox value=1 model="model.destajo" />
                            @error('model.destajo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>