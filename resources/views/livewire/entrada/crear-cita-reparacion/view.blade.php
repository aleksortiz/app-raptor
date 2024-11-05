
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
                    <label>Fabricante</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <select wire:model.defer="marca" class="form-control">
                        <option></option>
                        @foreach ($fabricantes as $item)
                            <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca')
                        <span class="error text-danger">Seleccione Fabricante</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Linea</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="modelo" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('modelo')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
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

                    <input disabled wire:model.defer="cliente_nombre" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('cliente_id')
                        <span class="error text-danger">Seleccione Cliente</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>No. Reporte</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="no_reporte" type="text" class="form-control"
                        style="text-transform: uppercase" />
                    @error('no_reporte')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2 d-flex justify-content-end">
                    <label>Cita</label>
                </div>
                <div class="col-md-5 col-12 m-1">
                    <input wire:model.defer="cita" type="datetime-local" class="form-control"
                        style="text-transform: uppercase" />
                    @error('cita')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>


          </div>
        <div class="card-footer">
            <center>
                <button wire:click="create" class="btn btn-success"><i class="fa fa-check"></i> Registrar Cita</button>
            </center>


        </div>
    </div>
</div>
