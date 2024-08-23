<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$this->model?->description}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Marca</label>
                            <input wire:model.lazy="model.brand" wire:keydown.enter="save()" type="text" class="form-control" style="text-transform: uppercase;" />
                            @error('model.brand')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input wire:model.lazy="model.model" wire:keydown.enter="save()" type="text" class="form-control" style="text-transform: uppercase;" />
                            @error('model.model')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label>Año</label>
                            <input wire:model.lazy="model.year" wire:keydown.enter="save()" type="text" class="form-control" style="text-align: center" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                            @error('model.year')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Serie</label>
                            <input wire:model.lazy="model.serial" wire:keydown.enter="save()" type="text" class="form-control" />
                            @error('model.serial')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label>Ubicación</label>
                            <input wire:model.lazy="model.location" wire:keydown.enter="save()" type="text" class="form-control" style="text-transform: uppercase;" />
                            @error('model.location')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Estatus</label>
                            <select wire:model.lazy="model.status" class="form-control">
                                <option></option>
                                <option class="DISPONIBLE">DISPONIBLE</option>
                                <option class="EN REPARACION">EN REPARACION</option>
                                <option class="APARTADO">APARTADO</option>
                                <option class="VENDIDO">VENDIDO</option>
                            </select>
                            @error('model.status') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Estatus Legal</label>
                            <select wire:model.lazy="model.legal_status" class="form-control">
                                <option></option>
                                <option class="NACIONAL">NACIONAL</option>
                                <option class="IMPORTADO">IMPORTADO</option>
                                <option class="DECRETO">DECRETO</option>
                                <option class="OTRO">OTRO</option>
                            </select>
                            @error('model.legal_status') <span class="error text-danger">Seleccione estatus legal</span> @enderror
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-3">
                        <div class="form-group">
                            <label>Fecha de Compra</label>
                            <input wire:model.lazy="model.purchase_date" type="date" class="form-control" style="text-transform: uppercase;" />
                            @error('model.purchase_date')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label>Valor de Compra</label>
                            <input wire:model.lazy="model.purchase_price" wire:keydown.enter="save()" type="text" class="form-control" style="text-align: right" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                            @error('model.purchase_price')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>




                    <div class="col-1">
                        <div class="form-group">
                            <label for="iptVendido">Vendido</label>
                            <div>
                                <label class="content-input">
                                    <input id="iptVendido" wire:model="iptVendido" type="checkbox" />
                                    <i></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($this->iptVendido)
                        <div class="col-3">
                            <div class="form-group">
                                <label>Fecha de Venta</label>
                                <input wire:model.lazy="model.sale_date" type="date" class="form-control" style="text-transform: uppercase;" />
                                @error('model.sale_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label>Precio de Venta</label>
                                <input wire:model.lazy="model.sale_price" wire:keydown.enter="save()" type="text" class="form-control" style="text-align: right" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                @error('model.sale_price')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif


                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Notas / Comentarios</label>
                            <textarea rows="3" wire:model.lazy="model.notes" class="form-control"></textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>

                @if ($this->model?->id)
                    <button type="button" wire:click.prevent="save" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save" class="btn btn-success"><i class="fas fa-check"></i> Registrar</button>
                @endif


            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
