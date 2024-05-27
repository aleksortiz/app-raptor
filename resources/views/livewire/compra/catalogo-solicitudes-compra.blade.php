<div>
    <table class="table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Requisitor</th>
                <th>Estatus</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $row)
                <tr>
                    <td>{{ $row->id_paddy}}</td>
                    <td>{{ $row->fecha_creacion }}</td>
                    <td>{{ $row->user->name }}</td>
                    <td>{{ $row->estatus }}</td>
                    <td>
                        <livewire:compra.common.btn-detalles :solicitud="$row" :wire:key="$row->id" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</div>
