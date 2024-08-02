<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlUpdateServicio">
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
                    <label>Estatus de Servicio</label>
                    <select class="form-control" wire:model="estatus_servicio">
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="ESPERANDO REFACCIONES">ESPERANDO REFACCIONES</option>
                        <option value="CANCELADO">CANCELADO</option>
                        <option value="FINALIZADO">FINALIZADO</option>
                    </select>
                    @error('estatus_servicio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Técnico Asignado</label>
                    <input placeholder="Ej. Mario Perez | seleccione personal" class="form-control" wire:model="tecnico_asignado"></textarea>
                    @error('tecnico_asignado') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea placeholder="Ej. El filtro de aceite se encontraba tapado" class="form-control" wire:model="observaciones"></textarea>
                    @error('observaciones') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                @if ($estatus_servicio == 'FINALIZADO')
                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label>Fecha Concluido</label>
                                <input type="datetime-local" class="form-control" wire:model="fecha_concluido" />
                                @error('fecha_concluido') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                @endif

                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label>Costo</label>
                            <input placeholder="$0.00" style="text-align: right" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" class="form-control" wire:model="costoServicio" />
                            @error('costoServicio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>  
                    </div>
                </div>





            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="updateFlotillaServicio" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>