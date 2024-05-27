<div>
    <div>
        <table class="table projects">
            <thead>
                <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Mensaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->orden->comentarios as $elem)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $elem->created_at->format('m/d/Y h:i A') }}</td>
                    <td>{{ $elem->usuario->name }}</td>
                    <td>
                    @if ($elem->tipo == 'CANCELACION')
                    <button class="btn btn-danger btn-xs"><i class="fa fa-times"></i> CANCELACIÓN</button>
                    @endif
                    {{ $elem->mensaje }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>
    <br>
    <div class="row">
        <div class="col-6 m-2">
            <textarea wire:model="comentario.mensaje" class="form-control form-control-sm" rows="3"></textarea>
            <button wire:click="agregarComentario" class="btn btn-xs btn-success m-2"><i class="fas fa-comment"></i> Agregar Comentarios</button>
            @error('comentario.mensaje') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>