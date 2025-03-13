<div class="card m-0" style="min-height: 65vh;">
    <div style="overflow: scroll;" class="card-body">
        <div class="row">
            <div class="col-3">
                <h3>{{ $entrada->vehiculo }}</h3>
                <h5><b>Sucursal:</b><br> {{ $entrada->sucursal->nombre }}
                </h5>
                <hr>

                <h5 style="cursor: pointer" wire:click="$set('activeTab', 4)"><b>Cliente:</b><br>
                    {{ $entrada->cliente->nombre }}</h5>
                <hr>

                @if ($entrada->notas)
                    <h5><b>Notas:</b><br> {{ $entrada->notas }}</h5>
                    <hr>
                @endif

                @if ($entrada->serie)
                    <h5><b>Serie:</b><br> {{ $entrada->serie }}</h5>
                    <hr>
                @endif

                @if ($entrada->orden)
                    <h5><b>Orden:</b><br> {{ $entrada->orden }}</h5>
                    <hr>
                @endif

                @if ($entrada->numero_factura)
                    <h5><b>Factura:</b><br> {{ $entrada->numero_factura }}</h5>
                    <hr>
                @endif

                @if ($entrada->razon_social)
                    <h5><b>Razón Social:</b><br> {{ $entrada->razon_social }}</h5>
                    <hr>
                @endif

                @if ($entrada->rfc)
                    <h5><b>RFC:</b><br> {{ $entrada->rfc }}</h5>
                    <hr>
                @endif


            </div>
            <div class="col-9">
                {{-- <div class="row">
                    @if ($entrada->fecha_entrega)
                        <div class="col-3">
                            <label for="">Fecha de Entrega</label>
                            <h6 style="cursor: pointer;" wire:click="editFechaEntrega">
                                {{ $entrada->fecha_entrega_format }}</h6>
                        </div>
                    @else
                        <div class="col-3">
                            <button class="btn btn-secondary btn-sm" wire:click="entregarVehiculo"><i
                                    class="fas fa-car"></i> Entregar Vehículo</button>
                        </div>
                    @endif

                    @if ($entrada->fecha_pago)
                        <div class="col-3">
                            <label for="">Fecha de Pago</label>
                            <h6 style="cursor: pointer;" wire:click="editFechaPago">{{ $entrada->fecha_pago_format }}
                            </h6>
                        </div>
                    @else
                        <div class="col-3">
                            <button class="btn btn-secondary btn-sm" wire:click="pagarEntrada"><i
                                    class="fas fa-hand-holding-usd"></i> Pagar Entrada</button>
                        </div>
                    @endif
                </div> --}}


                @if ($inventario)
                  <h3>INVENTARIO: </h3>
                  <a href="/inventarios/{{$inventario->id}}/pdf" target="_blank" class="btn btn-secondary"><i class="fa fa-file-alt"></i> Ver Inventario</a>
                @else
                  <h3>INVENTARIO:</h3>
                  <a href="/registro-inventario?entradaId={{$this->entrada->id}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Crear Inventario</a>
                @endif

                <div class="mt-5">
                    @if($this->entrada->registros_factura->count() > 0)
                        <div class="row">
                            <div class="col">
                                <h5>Facturas Realizadas</h5>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Número de Factura</th>
                                            <th>Monto</th>
                                            <th>Notas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($this->entrada->registros_factura as $item)
                                            <tr>
                                                <td>{{ $item->fecha_creacion }}</td>
                                                <td>{{ $item->numero_factura }}</td>
                                                <td>@money($item->monto)</td>
                                                <td>{{ $item->notas ? $item->notas : "N/A" }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @else
                        <h5>**No se han registrado facturas**</h5>
                    @endif
                </div>




            </div>
        </div>


    </div>

    <div class="card-footer">
        <a class="btn btn-warning" href="/servicios/{{ $this->entrada->id }}/editar"><i class="fas fa-edit"></i> Editar
            Entrada</a>
    </div>
</div>
