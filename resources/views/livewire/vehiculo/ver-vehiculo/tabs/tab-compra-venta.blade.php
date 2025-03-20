<div class="card m-0" style="min-height: 65vh;">
    @if ($this->vehiculo->venta)
        <div class="card-body">
            <h1 class="text-center"> 💵 Vehículo Vendido 💵</h1>

            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <center>
                        <button class="btn btn-secondary btn-lg" wire:click="verContrato"><i class="fa fa-file-alt"></i> Ver Contrato</button>
                    </center>
                </div>
            </div>
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaVendedor">👤 Vendedor</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->vendedor }}</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaClienteNombre">👤 Comprador</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->cliente->nombre }}</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaCompradorDomicilio">🏠 Domicilio del Comprador</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->comprador_domicilio }}</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-2">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaFecha">📅 Fecha</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->fecha }}</p>
                    </div>
                </div>
                
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaLugar">📍 Lugar</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->vendedor }}</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-2">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaPrecioVenta">💰 Precio de Venta</h5>
                        <p style="#374151" class="h4">@money($this->vehiculo->venta->precio_venta)</p>
                    </div>
                </div>
        
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaAnticipo">💵 Anticipo</h5>
                        <p style="#374151" class="h4">@money($this->vehiculo->venta->anticipo)</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-2 col-xl-2">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaPlazos">⏱️ Plazos (Meses)</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->plazos }}</p>
                    </div>
                </div>
        
                <div class="col-12 col-lg-4 col-xl-2">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaKilometraje">🛞 Kilometraje</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->kilometraje }}</p>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-2">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaIdentificacion">🪪 Identificación</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->identificacion }}</p>
                    </div>
                </div>
        
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <h5 style="color: #1E3A8A" for="ventaNoIdentificacion">🔢 No. de Identificación</h5>
                        <p style="#374151" class="h4">{{ $this->vehiculo->venta->no_identificacion }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <center>
                        <button class="btn btn-danger btn-md" onclick="confirm('Eliminar Venta', 'deleteVenta')"><i class="fa fa-trash"></i> Eliminar Venta</button>
                    </center>
                </div>
            </div>
        </div>
    @else
        <div class="card-body">
            <h1 class="text-center"> 🚗 Vender Vehículo 🚗</h1>

            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        <label for="ventaVendedor">Vendedor</label>
                        <input type="text" class="form-control" wire:model.defer="ventaVendedor" style="text-transform: uppercase">
                        @error('ventaVendedor') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">   
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        @if ($this->ventaClienteId)
                            <button class="btn btn-danger btn-xs" wire:click="setCliente(0)"><i class="fa fa-minus"></i></button>
                        @else
                            <button class="btn btn-primary btn-xs" wire:click="$emit('initMdlSelectCliente')"><i class="fa fa-plus"></i></button>
                        @endif

                        <label for="ventaClienteNombre">Comprador</label>
                        <input readonly type="text" class="form-control" wire:model.defer="ventaClienteNombre" style="text-transform: uppercase">
                        @error('ventaClienteId') <span class="text-danger">Seleccione Cliente</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-6">
                    <div class="form-group">
                        <label for="ventaCompradorDomicilio">Domicilio del Comprador</label>
                        <input type="text" class="form-control" wire:model.defer="ventaCompradorDomicilio" style="text-transform: uppercase">
                        @error('ventaCompradorDomicilio') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-2">
                    <div class="form-group">
                        <label for="ventaFecha">Fecha</label>
                        <input type="date" class="form-control" wire:model.defer="ventaFecha">
                        @error('ventaFecha') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="ventaLugar">Lugar</label>
                        <input type="text" class="form-control" wire:model.defer="ventaLugar" style="text-transform: uppercase">
                        @error('ventaLugar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-3">
                    <div class="form-group">
                        <label for="ventaPrecioVenta">Precio de Venta</label>
                        <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right;" class="form-control" wire:model.defer="ventaPrecioVenta">
                        @error('ventaPrecioVenta') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
        
                <div class="col-12 col-lg-3">
                    <div class="form-group">
                        <label for="ventaAnticipo">Anticipo</label>
                        <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right;" class="form-control" wire:model.defer="ventaAnticipo">
                        @error('ventaAnticipo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-2 col-xl-2">
                    <div class="form-group">
                        <label for="ventaPlazos">Plazos (Meses)</label>
                        <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" class="form-control" wire:model.defer="ventaPlazos">
                        @error('ventaPlazos') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
        
                <div class="col-12 col-lg-4 col-xl-2">
                    <div class="form-group">
                        <label for="ventaKilometraje">Kilometraje</label>
                        <input type="text" maxlength="10" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" class="form-control" wire:model.defer="ventaKilometraje">
                        @error('ventaKilometraje') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-2">
                    <div class="form-group">
                        <label for="ventaIdentificacion">Identificación</label>
                        <input type="text" class="form-control" wire:model.defer="ventaIdentificacion" style="text-transform: uppercase">
                        @error('ventaIdentificacion') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
        
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="ventaNoIdentificacion">No. de Identificación</label>
                        <input type="text" class="form-control" wire:model.defer="ventaNoIdentificacion" style="text-transform: uppercase">
                        @error('ventaNoIdentificacion') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-lg-3 col-12 col-lg-2 col-xl-1">
                    <div class="form-group">
                        <label for="ventaSendMail">Enviar correo</label>
                        <label class="content-input">
                            <input id="ventaSendMail" wire:model="ventaSendMail" type="checkbox" />
                            <i></i>
                        </label>
                    </div>
                </div>

                @if ($ventaSendMail)                
                    <div class="col-12 col-lg-4 col-xl-5">
                        <div class="form-group">
                            <label for="ventaMail">Correo (Varios correos separados por coma)</label>
                            <input type="text" class="form-control" wire:model.defer="ventaMail" style="text-transform: lowercase">
                            @error('ventaMail') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="offset-lg-3 col-12 col-md-6">
                    <center>
                        <button class="btn btn-success btn-lg" wire:click="createVenta"><i class="fa fa-handshake"></i> Vender Vehículo</button>
                    </center>
                </div>
            </div>
        </div>
    @endif
</div>