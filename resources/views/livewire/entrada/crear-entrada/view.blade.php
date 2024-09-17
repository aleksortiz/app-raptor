@section('title', __('Generar Entrada'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Generar Entrada</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">


            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Sucursal</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.sucursal_id" class="form-control">
                        <option></option>
                        @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>
                    @error('entrada.sucursal_id')
                        <span class="error text-danger">Seleccione Sucursal</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Origen</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.origen" class="form-control">
                        <option></option>
                        <option value="PARTICULAR">PARTICULAR</option>
                        <option value="ASEGURADORA">ASEGURADORA</option>
                        <option value="AGENCIA">AGENCIA</option>
                        <option value="GARANTIA">GARANTIA</option>
                    </select>
                    @error('entrada.origen')
                        <span class="error text-danger">Seleccione Origen</span>
                    @enderror
                </div>

            </div>

            <div class="row justify-content-center">

                <div class="col-2 d-flex justify-content-end">
                    <label>Aseguradora</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.aseguradora_id" class="form-control">
                        @foreach ($aseguradoras as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('entrada.aseguradora_id')
                        <span class="error text-danger">Seleccione Aseguradora</span>
                    @enderror
                </div>

            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Fabricante</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.fabricante_id" class="form-control">
                        <option></option>
                        @foreach ($fabricantes as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('entrada.fabricante_id')
                        <span class="error text-danger">Seleccione Fabricante</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Linea</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.modelo" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.modelo')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Notas</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.notas" type="text" class="form-control" />
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2">

                    <div style="float: right;">
                        <button wire:click="$emit('initMdlSelectCliente')" class="btn btn-xs btn-secondary"><i
                                class="fa fa-plus"></i></button>
                        <label>Cliente</label>
                    </div>

                </div>
                <div class="col-md-5 col-12 m-1">

                    <input disabled wire:model.defer="cliente.nombre" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.cliente_id')
                        <span class="error text-danger">Seleccione Cliente</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Serie</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.serie" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.serie')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Orden</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.orden" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.orden')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Razón Social</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.razon_social" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.razon_social')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>RFC</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.rfc" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.rfc')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Domicilio Fiscal</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.domicilio_fiscal" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.domicilio_fiscal')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Número de Factura</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.numero_factura" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('entrada.numero_factura')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}

            {<div class="row justify-content-center">
                <div class="col-7">
                    <h2>Servicios</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><button wire:click="addCosto" class="btn btn-xs btn-primary"><i
                                            class="fa fa-plus"></i></button></th>
                                <th>Concepto</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($costos as $costo)
                                <tr>
                                    <td><button wire:click="removeCosto({{ $loop->index }})"
                                            class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                                    <td>
                                        <input class="form-control" wire:model="costos.{{ $loop->index }}.concepto" />
                                        @error("costos.{$loop->index}.concepto")
                                            <span class="error text-danger">Concepto requerido, max:255 caracteres<span>
                                                @enderror
                                    </td>
                                    <td>
                                        <input class="form-control" wire:model="costos.{{ $loop->index }}.costo"
                                            style="text-align: right;" />
                                        @error("costos.{$loop->index}.costo")
                                            <span class="error text-danger">Costo requerido, min:0.00</span>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- <div class="row justify-content-center">
                <div class="col-7">
                    <h2>Refacciones</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><button wire:click="addRefaccion" class="btn btn-xs btn-primary"><i
                                            class="fa fa-plus"></i></button></th>
                                <th width="60%">Refacción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refacciones as $refaccion)
                                <tr>
                                    <td><button wire:click="removeRefaccion({{ $loop->index }})"
                                            class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                                    <td>
                                        <input class="form-control"
                                            wire:model="refacciones.{{ $loop->index }}.refaccion" />
                                        @error("refacciones.{$loop->index}.refaccion")
                                            <span class="error text-danger">Concepto requerido, max:255 caracteres<span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input class="form-control"
                                            wire:model="refacciones.{{ $loop->index }}.cantidad"
                                            style="text-align: center;"
                                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                        @error("refacciones.{$loop->index}.cantidad")
                                            <span class="error text-danger">Cantidad requerida, min: 1</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input class="form-control"
                                            wire:model="refacciones.{{ $loop->index }}.precio"
                                            style="text-align: right;"
                                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                        @error("refacciones.{$loop->index}.precio")
                                            <span class="error text-danger">Costo requerido, min:0.00</span>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}




        </div>
        <div class="card-footer">
            <center>
                <button wire:click="create" class="btn btn-success"><i class="fa fa-check"></i> Registrar
                    Entrada</button>
            </center>
        </div>
    </div>
</div>
