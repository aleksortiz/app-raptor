<div>
    @if ($ordenes_aut->count() > 0)        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Proyecto</th>
                    <th>Proveedor</th>
                    <th>Creada por:</th>
                    <th>Detalle</th>
                    <th>PDF</th>
                    <th>Enviar</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($ordenes_aut as $item)
                <tr>
                    <td>{{$item->id_paddy}}</td>
                    <td>{{$item->fecha_creacion}}</td>
                    <td>{{$item->proyecto->titulo}}</td>
                    <td>{{$item->proveedor->nombre}}</td>
                    <td>{{$item->user->name}}</td>
                    <td><livewire:compra.common.btn-compra-detalles :orden="$item" wire:key="btn-compra-detalle2-{{$item->id}}" /></td>
                    <td><a href="/compras/{{ $item->id }}/pdf" class="btn btn-xs btn-secondary"><i class="fa fa-file-pdf"></i> Ver PDF</a></td>
                    <td>
                        <livewire:contacto.common.btn-mdl-enviar-correo 
                        wire:key="ord_aut_{{$item->id}}"
                        card-title="Enviar Orden de Compra" 
                        asunto-correo="Orden de compra: {{$item->nombre}}"
                        mensaje-correo="Se ha generado orden de compra, mas información en el documento adjunto "
                        :model="$item" :contactos="$item->contactos" />
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="m-3">
            {{ $ordenes_aut->links() }}
        </div>
    @else
        <div class="m-3 p-3">
            <h4>No hay ordenes para mostrar</h4>
        </div>
    @endif
</div>
