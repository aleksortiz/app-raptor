<div class="card m-0" style="min-height: 65vh;">
    <div style="overflow: scroll;" class="card-body">
        <div class="row">
            <div class="col-3">

                <div class="p-3">
                    <a class="btn btn-success btn-md" target="_blank" href="https://web.whatsapp.com/send?text=¡Mira%20este {{$this->vehiculo->descripcion}}!%20{{ url("vehiculos/share/" . $this->vehiculo->id) }}"><i class="fab fa-whatsapp"></i> Enviar Whatsapp</a>
                    <button class="btn btn-primary btn-md" wire:click="shareWhatsapp"><i class="fa fa-envelope"></i> Enviar Correo</button>
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


            </div>
            <div class="col-9">

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
