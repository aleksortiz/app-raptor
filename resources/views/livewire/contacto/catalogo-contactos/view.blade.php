<div>
    <div class="form-group m-3">
        <label for="keyWord">Buscar</label>
        <input type="text" wire:model.lazy="keyWord"  class="form-control" placeholder="Busqueda">
    </div>
    <div class="m-2">

        @can($this->adminCan)
            <livewire:contacto.common.btn-create-contacto :morphsModel="$this->morphsModel" :wire:key="'mdl-contacto'">
        @endcan
    </div>

    <table class="table table-hover projects">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfonos</th>
                <th>Departamento</th>
                @can($this->adminCan)
                <th>Opciones</th>
                @endcan
            </tr>
        </thead>
        <tbody>

            @foreach ($contactos as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->prefijo_nombre }}</td>
                    <td>{{ $row->correo }}</td>
                    <td>
                        <livewire:contacto.common.btn-telefonos :contacto="$row" :wire:key="$loop->iteration">
                    </td>
                    <td>{{ $row->depto }}</td>
                    @can($this->adminCan)
                    <td>
                        <livewire:contacto.btn-save-contacto :contacto="$row" :wire:key="'mdl-contacto-'.$row->id">
                        <button class="btn btn-xs btn-danger" onclick="destroy({{$row->id}}, 'Contacto: {{$row->nombre}}', 'destroyContacto')"><i class="fas fa-trash"></i></button>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contactos->links() }}
</div>