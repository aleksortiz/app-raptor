<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Vehículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" wire:model.lazy="marca" list="marcas" class="form-control" id="marca" placeholder="Marca">
                            <datalist id="marcas">
                                @foreach ($marcas as $item)
                                    <option value="{{ $item }}">
                                @endforeach
                            </datalist>
                            @error('marca') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" wire:model.lazy="modelo" list="modelos" class="form-control" id="modelo" placeholder="Modelo">
                            <datalist id="modelos">
                                @foreach ($modelos as $item)
                                    <option value="{{ $item }}">
                                @endforeach
                            </datalist>
                            @error('modelo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="year">Año</label>
                            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center" maxlength="4" type="text" wire:model.lazy="year" class="form-control" id="year" placeholder="Año">
                            @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" wire:model.lazy="color" class="form-control" id="color" placeholder="Color">
                            @error('color') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="serie">Serie</label>
                            <input type="text" wire:model.lazy="serie" class="form-control" id="serie" placeholder="Serie">
                            @error('serie') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="placa">Placas</label>
                            <input type="text" wire:model.lazy="placa" class="form-control" id="placa" placeholder="Placas">
                            @error('placa') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                </div>

                <div class="row">


                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="factura">Factura</label>
                            <input type="text" wire:model.lazy="factura" class="form-control" id="factura" placeholder="Factura">
                            @error('factura') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="pedimento">Pedimento</label>
                            <input type="text" wire:model.lazy="pedimento" class="form-control" id="pedimento" placeholder="Pedimento">
                            @error('pedimento') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="precio_venta">Precio Venta</label>
                            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" wire:model.lazy="precio_venta" class="form-control" id="precio_venta" placeholder="Precio Venta">
                            @error('precio_venta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="numero_lote">Número de Lote</label>
                            <input type="text" wire:model.lazy="numero_lote" class="form-control" id="numero_lote" placeholder="Número de Lote">
                            @error('numero_lote') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="estado">Estatus</label>
                            <input type="text" wire:model.lazy="estado" class="form-control" id="estado" placeholder="Estatus">
                            @error('estado') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="registrar" class="btn btn-success"><i class="fas fa-check"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
