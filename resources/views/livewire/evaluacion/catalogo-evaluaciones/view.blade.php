@section('title', __($this->model_name_plural))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catalogo de {{ $this->model_name_plural }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="form-group m-3">
                <label for="keyWord">Buscar</label>
                <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
            </div>

            @canany(['administrar-clientes'])
            <button class="btn btn-xs btn-success m-2" wire:click="mdlCreate"><i class="fas fa-plus"></i> Agregar
                {{ $this->model_name }}</button>
            @endcanany

            <table class="table table-hover">

                <thead>
                    
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Sucursal</th>
                        <th>Usuario</th>
                        <th>No. Reporte</th>
                        <th>Vehículo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id_paddy }}</td>
                            <td>{{ $row->fecha_creacion }}</td>
                            <td>{{ $row->nombre_sucursal }}</td>
                            <td>{{ $row->usuario->name }}</td>
                            <td>{{ $row->no_reporte }}</td>
                            <td>{{ $row->vehiculo }}</td>
                            <td><a href="/evaluaciones/{{ $row->id }}" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> Ver Evaluación</a></td></td>
                            {{-- <td><button wire:click="showPhotos({{$row->id}})" class="btn btn-xs btn-success"><i class="fa fa-camera"></i> Ver Fotos</button></td>
                            <td><a href="/evaluaciones/adjuntar_fotos/{{ $row->id }}" class="btn btn-xs btn-warning"><i class="fa fa-camera"></i> Subir Fotos</a></td>
                            <td><a href="/evaluaciones/{{ $row->id }}" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> Ver Evaluación</a></td> --}}
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    {{ $data->links() }}

    @include('livewire.evaluacion.catalogo-evaluaciones.modal')
    @include('livewire.evaluacion.catalogo-evaluaciones.partials.modalPhotos')
