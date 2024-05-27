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
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        @can('administrar-clientes')
                        <th>Opciones</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id_paddy }}</td>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->razon_social }}</td>
                            <td>{{ $row->direccion }}</td>
                            <td><a href="/clientes/{{ $row->id }}" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> Ver Clientes</a></td>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $data->links() }}

    @include('livewire.cliente.catalogo-clientes.modal')
</div>
