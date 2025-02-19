<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        <button class="m-3 btn btn-xs btn-success" wire:click="showMdlTelefono(0)"><i class="fa fa-phone"></i> Agregar Teléfono</button>
        <table class="table table-hover projects">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Número</th>
                    <th>Notas</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($cliente->telefonos as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->tipo}}</td>
                    <td>{{$item->numero}}</td>
                    <td>{{$item->notas}}</td>
                    <td>
                        <button wire:click="showMdlTelefono({{$item->id}})" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editar</button>
                        <button onclick="destroy('{{ $item->id }}', 'teléfono: {{ $item->numero }}', 'destroyTelefono')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>