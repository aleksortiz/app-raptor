<div class="pt-3">
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Registros por QR</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">


            <div class="row m-3">
                <div class="col-5">
                    <div class="form-group">
                        <label for="search">Buscar</label>
                        <input type="text" wire:model.lazy="search" class="form-control" id="search" placeholder="Busqueda">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="orderBy">Ordenar Por</label>
                        <select wire:model.lazy="orderBy" id="orderBy" class="form-control">
                            <option value="fecha_cita">Fecha de Cita</option>
                            <option value="created_at">Fecha de Registro</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Número de Reporte</th>
                        <th>Vehículo</th>
                        <th>Cita para:</th>
                        <th>Fecha</th>
                        {{-- <th>Opciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->cliente_nombre }}</td>
                            <td>{{ $row->numero_reporte }}</td>
                            <td>{{ $row->vehiculo }}</td>
                            <td>{!! $row->tipo_span !!}</td>
                            <td>{{ $row->fecha_cita_format }}</td>
                            {{-- <td> --}}
                                {{-- <a href="/servicio-flotillas/{{ $row->identificador }}" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> Ver Clientes</a> --}}
                                {{-- <button class="btn btn-xs btn-warning" wire:click="verFlotilla({{ $row->id }})"><i class="fa fa-car"></i> Flotilla</button> --}}
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $data->links() }} --}}


        </div>

    </div>
</div>
