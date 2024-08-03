<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlProviders">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="provider_id">Proveedores</label>
                    <select wire:model="providerIdCombo" class="form-control" id="provider_id">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->nombre }}</option>
                        @endforeach
                    </select>
                    @error('providerIdCombo') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="setProvider" class="btn btn-success"><i
                    class="fas fa-check"></i> Aceptar</button>

            </div>
        </div>
    </div>
</div>
