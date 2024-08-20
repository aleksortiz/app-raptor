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

                <div style="cursor: pointer" wire:click="$set('activeTab', 2)" class="d-flex justify-content-between">
                    <h5><b>Servicios: </b></h5>
                    <h5> @money($entrada->total_costos)</h5>
                </div>
                <hr>

                <div style="cursor: pointer" wire:click="$set('activeTab', 5)" class="d-flex justify-content-between">
                    <h5><b>Refacciones: </b></h5>
                    <h5> @money($entrada->total_refacciones)</h5>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <h5><b>TOTAL: </b></h5>
                    <h5> @money($entrada->total)</h5>
                </div>
                <hr>

                <div style="cursor: pointer" wire:click="$set('activeTab', 6)" class="d-flex justify-content-between">
                    <h5><b>Materiales: </b></h5>
                    <h5> @money($entrada->total_materiales)</h5>
                </div>
                <hr>



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

                <br><br><br>
                <h1>*INVENTARIO: Seccion Pendiente*</h1>


                {{-- <div class="row">

                    @if ($entrada->refacciones->count() > 0)
                        @if ($entrada->fecha_pago_refacciones)
                            <div class="col-3">
                                <label for="">Fecha de pago refacciones</label>
                                <h6 style="cursor: pointer;" wire:click="editFechaPagoRefacciones">
                                    {{ $entrada->fecha_pago_refacciones }}</h6>
                            </div>
                        @else
                            <div class="col-3">
                                <button class="btn btn-secondary btn-sm" wire:click="pagarRefacciones"><i
                                        class="fas fa-wrench"></i> Pagar Refacciones</button>
                            </div>
                        @endif
                    @endif


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






                </div>
                <br>

                <h4>Areas de Trabajo</h4>
                @include('livewire.entrada.ver-entrada.partials.car-layout') --}}

                {{-- <h1>INVENTARIO: ***Pendiente***</h1> --}}





            </div>
        </div>


    </div>

    <div class="card-footer">
        <a class="btn btn-warning" href="/servicios/{{ $this->entrada->id }}/editar"><i class="fas fa-edit"></i> Editar
            Entrada</a>
    </div>
</div>
