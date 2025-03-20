<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">

        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-12 col-md-3">

                <h5><b>Vehículo:</b><br>{{ $vehiculo->descripcion }}</h5>
                <hr>

                @if ($vehiculo->numero_lote)
                    <h5><b>Número de Lote:</b><br> {{ $vehiculo->numero_lote }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->estado)
                    <h5><b>Estatus:</b><br> {{ $vehiculo->estado }}</h5>
                    <hr>
                @endif

                <h5><b>Precio Venta:</b><br> @money($vehiculo->precio_venta) {{$this->vehiculo->moneda}}</h5>
                <hr>

                @if ($this->vehiculo->moneda == 'USD')
                    <h5><b>Precio en MXN:</b><br> @money($vehiculo->precio_venta_mxn) MXN</h5>
                    <hr>
                @endif

                @if ($vehiculo->placa)
                    <h5><b>Placa:</b><br> {{ $vehiculo->placa }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->serie)
                    <h5><b>Serie:</b><br> {{ $vehiculo->serie }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->factura)
                    <h5><b>Factura:</b><br> {{ $vehiculo->factura }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->pedimento)
                    <h5><b>Pedimento:</b><br> {{ $vehiculo->pedimento }}</h5>
                    <hr>
                @endif

                <h5><b>Descripción de Venta:</b></h5>
                <textarea wire:model.defer="descripcionVenta" style="resize: none;" class="form-control" rows="4"></textarea>
                <button wire:click="saveDescripcionVenta" class="btn btn-primary btn-xs mt-2">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
            <!-- /Columna Izquierda -->

            <!-- Columna Derecha -->
            <div class="col-12 col-md-9">

                <div class="row">
                    <div class="col col-md-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Costos Estimados</b></span>
                                <span class="info-box-number">@money($this->vehiculo->total_gastos_estimacion)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Costos Reales</b></span>
                                <span class="info-box-number">@money($this->vehiculo->total_gastos)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-hand-holding-usd"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Utilidad Estimada</b></span>
                                <span class="info-box-number">@money($this->vehiculo->utilidad_estimada)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-hand-holding-usd"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Utilidad Real</b></span>
                                <span class="info-box-number">@money($this->vehiculo->utilidad_final)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-2">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-6 mb-2">
                            <button class="btn btn-primary btn-xs" wire:click="saveGastos">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button class="btn btn-success btn-xs" wire:click="addGasto">
                                <i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 mb-2">
                            <select wire:model="vehiculo.moneda" class="form-control pull-right">
                                <option value="MXN">Pesos MXN</option>
                                <option value="USD">Dolares USD</option>
                            </select>
                        </div>

                        @if ($this->vehiculo->moneda == 'USD')
                            <div class="col-6 col-md-4 col-lg-3 mb-2">
                                <input wire:model.defer="vehiculo.cotizacion_usd" type="text"
                                       class="form-control pull-right"
                                       style="text-align: right"
                                       onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                       placeholder="Tipo de Cambio" />
                                @error('vehiculo.cotizacion_usd')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Haz la tabla responsive para pantallas pequeñas -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>Concepto</th>
                                <th width="20%">Estimación</th>
                                <th width="20%">Costo Real</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($vehiculo->gastos as $gasto)
                            @php
                                $estimacion = $this->vehiculo->gastos[$loop->index]->estimacion;
                                $monto = $this->vehiculo->gastos[$loop->index]->monto;
                                $isEstimacionValid = (!empty($estimacion) && intval($estimacion) > 0) ? 'success' : 'danger';
                                $isMontoValid = (!empty($monto) && intval($monto) > 0) ? 'success' : 'danger';
                            @endphp
                            <tr>
                                <td>
                                    <button class="btn btn-danger btn-xs" onclick="destroy({{$gasto->id}}, 'Gasto', 'deleteGasto')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.descripcion"
                                           type="text" class="form-control" />
                                    @error('vehiculo.gastos.'.$loop->index.'.descripcion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.estimacion"
                                           type="text"
                                           style="text-align: right;"
                                           class="form-control border-{{ $isEstimacionValid }}"
                                           onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                    @error('vehiculo.gastos.'.$loop->index.'.estimacion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.monto"
                                           type="text"
                                           style="text-align: right;"
                                           class="form-control border-{{ $isMontoValid }}"
                                           onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                    @error('vehiculo.gastos.'.$loop->index.'.monto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Fin tabla responsive -->

            </div>
            <!-- /Columna Derecha -->
        </div>
    </div>

    <div class="card-footer">

        <div class="row justify-content-between">
            <a class="btn btn-warning" wire:click="$emit('showModal','#mdlEdit')">
                <i class="fas fa-edit"></i> Editar Datos
            </a>
    
            <button class="btn btn-info" wire:click="mdlSendMail">
                <i class="fa fa-envelope"></i> Enviar Correo
            </button>
    
            <a class="btn btn-success" target="_blank"
               href="https://web.whatsapp.com/send?text=¡Mira%20este {{$this->vehiculo->descripcion}}!%20{{ url("vehiculos/share/" . $this->vehiculo->id) }}">
                <i class="fab fa-whatsapp"></i> Whatsapp
            </a>
    
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url("vehiculos/share/" . $this->vehiculo->id) }}"
               target="_blank" class="btn btn-primary">
                <i class="fab fa-facebook"></i> Facebook
            </a>
            
            <a class="btn btn-secondary" target="_blank"
               href="{{ url("vehiculos/share/" . $this->vehiculo->id) }}">
                <i class="fa fa-eye"></i> Ver
            </a>
        </div>


    </div>
</div>
