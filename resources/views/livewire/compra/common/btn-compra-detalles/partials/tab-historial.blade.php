<div>
    <div>
        <table class="table projects">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->orden->status_logs as $elem)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $elem->created_at->format('m/d/Y h:i A') }}</td>
                    <td>{{ $elem->user->name }}</td>
                    <td><button class="btn btn-xs {{$elem->status_color}}">{{ $elem->status }}</button></td>
                    <td>{{ $elem->comments ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>