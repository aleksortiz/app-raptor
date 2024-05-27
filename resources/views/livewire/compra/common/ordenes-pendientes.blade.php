<div>
    @if ($ordenes_pend->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Proyecto</th>
                    <th>Proveedor</th>
                    <th>Creada por:</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($ordenes_pend as $item)
                <tr>
                    <td>{{$item->id_paddy}}</td>
                    <td>{{$item->fecha_creacion}}</td>
                    <td>{{$item->proyecto->titulo}}</td>
                    <td>{{$item->proveedor->nombre}}</td>
                    <td>{{$item->user->name}}</td>
                    <td><livewire:compra.common.btn-compra-detalles :orden="$item" wire:key="ord_pend_{{$item->id}}" /></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="m-3">
            {{ $ordenes_pend->links() }}
        </div>
    @else
        <div class="m-3 p-3">
            <h4>No hay ordenes para mostrar</h4>
        </div>
    @endif
</div>
