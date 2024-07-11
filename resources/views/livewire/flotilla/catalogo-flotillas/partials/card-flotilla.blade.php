<div class="row">
    <div class="col-4">
        <div style="height: 75vh;" class="card">
            <div class="card-header">
                <h3 class="card-title">Flotillas</h3>
                <div class="card-tools">
                    <button type="button" wire:click="mdlCrearFlotilla" class="btn btn-xs btn-success"><i class="fas fa-plus"></i> Nueva Flotilla</button>
                </div>
            </div>
            <div class="card-body p-0">

                <div class="ml-3 mt-2">
                    <h5>Cliente: {{$this->cliente->nombre}}</h5>
                </div>
    
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cant.</th>
                            <th>Selecc.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flotillas as $row)
                        <tr>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->unidades->count() }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" wire:click="selectFlotilla({{ $row->id }})"><i class="fa fa-car"></i> Selecc.</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
        </div>
        {{ $flotillas->links() }}
    </div>

    <div class="col">
        <div style="height: 75vh;" class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $this->selectedFlotilla?->nombre ?? 'Unidades' }}</h3>
                <div class="card-tools">
                    @if ($this->selectedFlotilla)
                        <button type="button" wire:click="mdlCrearUnidad" class="btn btn-xs btn-success"><i class="fas fa-plus"></i> Nueva Unidad</button>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">

                @if ($this->selectedFlotilla)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vehiculo</th>
                                <th>Placas</th>
                                <th>Estado</th>
                                <th>Kilometraje</th>
                                <th>Servicios</th>
                                {{-- <th>Editar</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->selectedFlotilla?->unidades ?? [] as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->vehiculo }}</td>
                                <td>{{ $row->placas ? $row->placas : "N/A" }}</td>
                                <td>{{ $row->estado }}</td>
                                <td>@qty($row->kilometraje)</td>
                                <td>
                                    <button class="btn btn-info btn-xs" wire:click="selectUnidad({{ $row->id }})"><i class="fa fa-car"></i> Servicios</button>
                                </td>
                                {{-- <td>
                                    <button class="btn btn-warning btn-xs" wire:click="mdlEditarUnidad({{ $row->id }})"><i class="fa fa-edit"></i></button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    
                    <center>
                        <img class="m-5" width="60%" src="{{ asset('images/logo.png') }}">
                        <h1 class="text-center">Seleccione una flotilla</h1>
                    </center>
                @endif

            </div>
        </div>
        {{ $flotillas->links() }}
    </div>

</div>