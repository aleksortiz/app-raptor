<div>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Refacción</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label for="numero_reporte">No. Reporte</label>
                                <input wire:model.defer="numero_reporte" maxlength="11" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" id="numero_reporte" placeholder="No. Reporte">
                                @error('numero_reporte') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
    
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                @if($this->proveedor_id)
                                    <button wire:click="$emit('setProveedor', 0)" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></button>
                                @else
                                    <button wire:click="$emit('showModal', '#mdlSelectProveedor')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>
                                @endif
    
                                <label for="proveedor_name">Proveedor</label>
                                <input disabled wire:model.defer="proveedor_name" type="text" class="form-control" id="proveedor_name" placeholder="Seleccione Proveedor">
                                @error('proveedor_id') <span class="text-danger">Seleccione Proveedor</span> @enderror
                            </div>
                        </div>
    
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input wire:model.defer="descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripción">
                                @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
    
                    </div>
    
                    <div class="row" >
                        <div class="col-3">
                            <div class="form-group">
                                <label for="numero_parte">No. Parte</label>
                                <input wire:model.defer="numero_parte" type="text" class="form-control" id="numero_parte" placeholder="No. Parte">
                                @error('numero_parte') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-4">
    
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <input wire:model.defer="ubicacion" type="text" class="form-control" id="ubicacion" placeholder="Ubicación">
                                @error('ubicacion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="condicion">Condición</label>
                                <select wire:model.defer="condicion" class="form-control" id="condicion">
                                    <option value="">-- Seleccione Condición --</option>
                                    <option value="NUEVA ORIGINAL">NUEVA ORIGINAL</option>
                                    <option value="NUEVA GENERICA">NUEVA GENERICA</option>
                                    <option value="USADA ORIGINAL">USADA ORIGINAL</option>
                                    <option value="USADA GENERICA">USADA GENERICA</option>
                                </select>
                                @error('condicion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
    
                    </div>
    
    
    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="year">Notas</label>
                                <textarea style="resize: none;" wire:model.defer="notas" class="form-control" id="notas" rows="4" maxlength="255" placeholder="Notas"></textarea>
                            </div>
                        </div>
    
                    </div>
    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="create"><i class="fas fa-check"></i> Registrar</button>
                </div>
            </div>
        </div>
    </div>
    
    @livewire('proveedor.common.mdl-select-proveedor', ['emitAction' => 'setProveedor'])

</div>    
