<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Vehículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" wire:model.lazy="vehiculo.marca" list="marcas" class="form-control" id="marca" placeholder="Marca">
                            <datalist id="marcas">
                                @foreach ($marcas as $item)
                                    <option value="{{ $item }}">
                                @endforeach
                            </datalist>
                            @error('vehiculo.marca') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" wire:model.lazy="vehiculo.modelo" list="modelos" class="form-control" id="modelo" placeholder="Modelo">
                            <datalist id="modelos">
                                @foreach ($modelos as $item)
                                    <option value="{{ $item }}">
                                @endforeach
                            </datalist>
                            @error('vehiculo.modelo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="year">Año</label>
                            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center" maxlength="4" type="text" wire:model.lazy="vehiculo.year" class="form-control" id="year" placeholder="Año">
                            @error('vehiculo.year') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" wire:model.lazy="vehiculo.color" class="form-control" id="color" placeholder="Color">
                            @error('vehiculo.color') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="serie">Serie</label>
                            <input type="text" wire:model.lazy="vehiculo.serie" class="form-control" id="serie" placeholder="Serie">
                            @error('vehiculo.serie') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="placa">Placas</label>
                            <input type="text" wire:model.lazy="vehiculo.placa" class="form-control" id="placa" placeholder="Placas">
                            @error('vehiculo.placa') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                </div>

                <div class="row">


                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="factura">Factura</label>
                            <input type="text" wire:model.lazy="vehiculo.factura" class="form-control" id="factura" placeholder="Factura">
                            @error('vehiculo.factura') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="pedimento">Pedimento</label>
                            <input type="text" wire:model.lazy="vehiculo.pedimento" class="form-control" id="pedimento" placeholder="Pedimento">
                            @error('vehiculo.pedimento') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="precio_venta">Precio Venta</label>
                            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" wire:model.lazy="vehiculo.precio_venta" class="form-control" id="precio_venta" placeholder="Precio Venta">
                            @error('vehiculo.precio_venta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="numero_lote">Número de Lote</label>
                            <input type="text" wire:model.lazy="vehiculo.numero_lote" class="form-control" id="numero_lote" placeholder="Número de Lote">
                            @error('vehiculo.numero_lote') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="estado">Estatus</label>
                            <input type="text" wire:model.lazy="vehiculo.estado" class="form-control" id="estado" placeholder="Estatus">
                            @error('vehiculo.estado') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="saveData" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
