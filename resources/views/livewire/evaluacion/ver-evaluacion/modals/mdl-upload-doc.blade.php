<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlUploadDocument">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Tipo</label>
                            <input list="tiposDoc" wire:model.defer="tipoDocumento" style="text-transform: uppercase;" type="text" class="form-control" />
                            <datalist id="tiposDoc">
                                @foreach ($this->requiredDocs as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </datalist>
                            @error('tipoDocumento')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Subir Documento</label>
                            <input type="file" wire:model.defer="documento" class="form-control" />
                            @error('documento')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <div wire:loading.remove wire:target="subirDocumento">
                    <button type="button" wire:click.prevent="subirDocumento()" class="btn btn-primary"><i
                        class="fas fa-check"></i> Aceptar</button>
                </div>
                <div wire:loading wire:target="subirDocumento">
                    <button type="button" wire:click.prevent="subirDocumento()" class="btn btn-info"><i
                        class="fas fa-spin fa-spinner" disabled></i> Subiendo Archivo...</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
