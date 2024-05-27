@section('title', __("Personal"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Personal</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row p-3">

                <div class="col">
                    <div class="form-group">
                        <label for="keyWord">Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
                    </div>
                </div>

            </div>

            <button class="btn btn-xs btn-success m-2" wire:click="mdlCreate"><i class="fas fa-plus"></i> Agregar {{ $this->model_name }}</button>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Personal</th>
                        <th>Sueldo</th>
                        <th>Domicilio</th>
                        <th>Contacto Emergencia</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nombre }}</td>
                        <td>@money($row->sueldo)</td>
                        <td>{{ $row->domicilio ? $row->domicilio : "N/A" }}</td>
                        <td>{{ $row->contacto_emergencia ? $row->contacto_emergencia : "N/A" }}</td>
                        <td><button wire:click="mdlEdit({{ $row->id }})" class="btn btn-xs btn-primary"><i class="fa fa-user-tie"></i> Editar</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $data->links() }}

    @include('livewire.personal.catalogo-personal.modal')

</div>
