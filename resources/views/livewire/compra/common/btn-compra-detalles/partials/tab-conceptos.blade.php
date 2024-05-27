<div class="row">
    <div class="col-3 mt-3">
        <h5>Folio: {{ $this->orden->id_paddy }}</h5>
        <hr>
        <h5>Fecha: {{ $this->orden->fecha_creacion }}</h5>
        <hr>
        <h5>Comprador: {{ $this->orden->user->name }}</h5>
        <hr>
        {{-- @if ($this->orden->proveedor_id)
            <h5>Proveedor: {{$this->orden->proveedor->nombre}}</h5>
            <hr>
            <h5>Dirección: {{$this->orden->proveedor->direccion}}</h5>
            <hr>
        @endif --}}
        <button
            class='btn {{ $this->orden->estatus_color }}'>{{ $this->orden->estatus }}</button>
        <br>
        <br>

        @if ($this->orden->estatus == 'AUTORIZADO')
            <label class="m-0">Autorizado por:
                {{ $this->orden->autorizado_por->name }}</label><br>
            <p>Fecha: {{ $this->orden->fecha_autorizacion }}</p>
            <p>{{ $this->orden->comentarios_autorizacion }}</p>
        @endif
        @if ($this->orden->estatus == 'RECHAZADO')
            <label class="m-0">Rechazado por:
                {{ $this->orden->rechazado_por }}</label><br>
            <p>Fecha: {{ $this->orden->fecha_rechazo }}</p>
            <p>{{ $this->orden->motivos_rechazo }}</p>
        @endif

        @if ($this->orden->estatus == 'PENDIENTE AUTORIZAR' && auth()->user()->can('autorizar-orden-compra'))
            <div class="row">
                <div class="col">
                    <label>Autorizar</label>
                    <label class="content-input">
                        <input wire:model="autorizar" type="checkbox" />
                        <i></i>
                    </label>
                </div>
                <div class="col">
                    <label>Rechazar</label>
                    <label class="content-input red">
                        <input wire:model="rechazar" type="checkbox" />
                        <i></i>
                    </label>
                </div>
                <div class="col">
                    <br>
                    @if ($this->autorizar)
                        <button wire:click="autorizar"
                            class='btn btn-success btn-xs'><i
                                class="fa fa-check"></i><br>AUTORIZAR</button>
                    @endif
                    @if ($this->rechazar)
                        <button wire:click="rechazar"
                            class='btn btn-danger btn-xs'><i
                                class="fa fa-times"></i><br>RECHAZAR</button>
                    @endif
                </div>

            </div>
            <div class="row">
                @if ($this->autorizar || $this->rechazar)
                    <label>{{ $this->autorizar ? 'Comentarios' : 'Motivos' }}</label>
                    <textarea wire:model="comentarios" class="form-control"></textarea>
                    @error('comentarios')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                @endif
            </div>
        @endif

    </div>
    <div class="col">
        <table class="table">
            <thead>
                <tr>
                    <th>Número de Parte</th>
                    <th>Descripción</th>
                    <th>Unidad de Venta</th>
                    <th>Cantidad Solicitada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->orden->conceptos as $item)
                    <tr>
                        <td>{{ $item->numero_parte }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td align="center">{{ $item->unidad_venta }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>