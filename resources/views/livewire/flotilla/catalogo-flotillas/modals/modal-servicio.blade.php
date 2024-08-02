<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCrearServicio">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipo de Servicio</label>
                    <input placeholder="Ej. Cambio de aceite" type="text" class="form-control" wire:model="tipoServicio">
                    @error('tipoServicio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea placeholder="Ej. 5 litros aceite QUAKER 10W-30, remplazo de filtro de aceite" class="form-control" wire:model="descripcionServicio"></textarea>
                    @error('descripcionServicio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label>Costo</label>
                            <input placeholder="$0.00" style="text-align: right" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" class="form-control" wire:model="costoServicio" />
                            @error('costoServicio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>  
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Fecha de Servicio</label>
                            <input type="datetime-local" class="form-control" wire:model="fechaServicio" />
                            @error('fechaServicio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ubicación</label>
                    <textarea placeholder="Ej. Lopez Mateos y Ejercito Nacional, frente a edificio color azul" class="form-control" maxlength="255" wire:model="ubicacionServicio"></textarea>
                    @error('ubicacionServicio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>



            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="createFlotillaServicio" type="button" class="btn btn-success"><i class="fas fa-check"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>