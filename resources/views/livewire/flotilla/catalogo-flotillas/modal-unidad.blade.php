<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCrearUnidad">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Flotilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Fabricante</label>
                            <input type="text" class="form-control" wire:model="fabricanteUnidad">
                            @error('fabricanteUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" class="form-control" wire:model="modeloUnidad">
                            @error('modeloUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Año</label>
                            <input type="text" class="form-control" wire:model="yearUnidad">
                            @error('yearUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Serie</label>
                            <input type="text" class="form-control" wire:model="serieUnidad">
                            @error('serieUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label>Kilometraje</label>
                            <input type="text" class="form-control" wire:model="kilometrajeUnidad">
                            @error('kilometrajeUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Placas</label>
                            <input type="text" class="form-control" wire:model="placasUnidad">
                            @error('placasUnidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="createFlotillaUnidad" type="button" class="btn btn-success"><i class="fas fa-car"></i> Crear Unidad</button> 
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>