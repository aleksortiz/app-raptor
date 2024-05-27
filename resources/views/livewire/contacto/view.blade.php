<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        <table class="table table-hover projects">
            <button class="btn btn-sm btn-success m-2" wire:click="mdlCreate"><i class="fas fa-plus">
                </i> Agregar Contacto 
            </button>
            <div class="form-group m-3">
                <label for="keyWord">Buscar</label>
                <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord"
                    placeholder="Busqueda">
            </div>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfonos</th>
                    <th>Departamento</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->prefijo_nombre }}</td>
                        <td>{{ $row->correo }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary m-2" wire:click="mdlTelefonos({{ $row->id }})">
                                <i class="fa fa-phone"></i> ({{$row->telefonos->count()}})
                            </button>
                        </td>
                        <td>{{ $row->departamento }}</td>
                        <td>
                            <button class="btn btn-xs btn-warning" wire:click="mdlEdit({{ $row->id }})"><i
                                    class="fa fa-edit"></i> Editar</button>
                            <button class="btn btn-xs btn-danger" wire:click="mdlDelete({{ $row->id }})"><i
                                    class="fas fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $data->links() }}

    @include('livewire.contacto.modal')
    @if ($model->id)
        <livewire:telefono.crud-telefono key="{{ now() }}" :morphsModel="$model" />
    @endif
</div>
