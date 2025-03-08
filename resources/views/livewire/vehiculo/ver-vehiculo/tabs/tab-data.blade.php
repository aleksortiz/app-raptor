<div class="card m-0" style="min-height: 65vh;">
    <div style="overflow: scroll;" class="card-body">
        <div class="row">
            <div class="col-3">

                <div class="p-3">
                    <button class="btn btn-warning btn-xs" wire:click="mdlSendMail"><i class="fa fa-envelope"></i> Enviar Correo</button>
                    <a class="btn btn-success btn-xs" target="_blank" href="https://web.whatsapp.com/send?text=¡Mira%20este {{$this->vehiculo->descripcion}}!%20{{ url("vehiculos/share/" . $this->vehiculo->id) }}"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url("vehiculos/share/" . $this->vehiculo->id) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fab fa-facebook"></i> Facebook</a>
                    <a class="btn btn-secondary btn-xs" target="_blank" href="{{ url("vehiculos/share/" . $this->vehiculo->id) }}"><i class="fa fa-eye"></i> Ver</a>
                </div>

                <h5><b>Marca:</b><br>{{ $vehiculo->marca }}</h5>
                <hr>

                <h5><b>Modelo:</b><br> {{ $vehiculo->modelo }}</h5>
                <hr>

                <h5><b>Año:</b><br> {{ $vehiculo->year }}</h5>
                <hr>

                <h5><b>Precio Venta:</b><br> @money($vehiculo->precio_venta) MXN</h5>
                <hr>

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
                <button wire:click="saveDescripcionVenta" class="btn btn-primary btn-xs mt-2"><i class="fa fa-save"></i> Guardar</button>
                <hr>


            </div>
            <div class="col-9">

                <div class="row">
                    <div class="col">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Costos Estimados</b></span>
                                <span class="info-box-number">@money($this->vehiculo->total_gastos_estimacion)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Costos Reales</b></span>
                                <span class="info-box-number">@money($this->vehiculo->total_gastos)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Utilidad</b></span>
                                <span class="info-box-number">@money($this->vehiculo->utilidad_final)</span>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="m-2">
                    <button class="btn btn-primary btn-xs" wire:click="saveGastos"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-success btn-xs" wire:click="addGasto"><i class="fa fa-plus"></i> Agregar</button>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th>Concepto</th>
                            <th width="20%">Estimacion</th>
                            <th width="20%">Costo Real</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculo->gastos as $gasto)
                            <tr>
                                <td><button class="btn btn-danger btn-xs" onclick="destroy({{$gasto->id}}, 'Gasto', 'deleteGasto')" ><i class="fa fa-times"></i></button></td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.descripcion" type="text" class="form-control" />
                                    @error('vehiculo.gastos.'.$loop->index.'.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.estimacion" type="text" style="text-align: right;" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                    @error('vehiculo.gastos.'.$loop->index.'.estimacion') <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                                <td>
                                    <input wire:model.defer="vehiculo.gastos.{{$loop->index}}.monto" type="text" style="text-align: right;" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                    @error('vehiculo.gastos.'.$loop->index.'.monto') <span class="text-danger">{{ $message }}</span> @enderror

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>


    </div>

    {{-- <div class="card-footer">
        <a class="btn btn-warning" href="/servicios/{{ $this->vehiculo->id }}/editar"><i class="fas fa-edit"></i> Editar
            Entrada</a>
    </div> --}}
</div>
