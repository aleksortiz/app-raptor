@section('title', __('Editar Entrada'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Entrada</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            
            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Sucursal</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.sucursal_id" class="form-control">
                        <option></option>
                        @foreach ($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                        @endforeach
                    </select>
                    @error('entrada.sucursal_id')
                        <span class="error text-danger">Seleccione Sucursal</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
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

                <div class="col-1 d-flex justify-content-end">
                    <label>Aseguradora</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.aseguradora_id" class="form-control">
                        <option></option>
                        @foreach ($aseguradoras as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    @error('entrada.aseguradora_id')
                        <span class="error text-danger">Seleccione Aseguradora</span>
                    @enderror
                </div>

            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Fabricante</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="entrada.fabricante_id" class="form-control">
                        <option></option>
                        @foreach ($fabricantes as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    @error('entrada.fabricante_id')
                        <span class="error text-danger">Seleccione Fabricante</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Linea</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.modelo" type="text" class="form-control" style="text-transform: uppercase" />
                    @error('entrada.modelo')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Notas</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.notas" type="text" class="form-control" />
                    @error('entrada.notas')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1">

                    <div style="float: right;">
                        <button wire:click="$emit('initMdlSelectCliente')" class="btn btn-xs btn-secondary"><i class="fa fa-plus"></i></button>
                        <label>Cliente</label>
                    </div>

                </div>
                <div class="col-md-5 col-12 m-1">

                    <input disabled wire:model.defer="cliente.nombre" type="text" class="form-control" style="text-transform: uppercase" />
                    @error('entrada.cliente_id')
                        <span class="error text-danger">Seleccione Cliente</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Serie</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.serie" type="text" class="form-control" style="text-transform: uppercase" />
                    @error('entrada.serie')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>Orden</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.orden" type="text" class="form-control" style="text-transform: uppercase" />
                    @error('entrada.orden')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- <div class="row justify-content-center">
                <div class="col-1 d-flex justify-content-end">
                    <label>No Factura</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="entrada.numero_factura" type="text" class="form-control" style="text-transform: uppercase" />
                    @error('entrada.numero_factura')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}




        </div>
        <div class="card-footer">
            <center>
            <button wire:click="edit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Entrada</button>
            </center>
        </div>
    </div>
</div>
