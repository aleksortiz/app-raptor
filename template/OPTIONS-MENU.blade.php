<td>
    <div>
        <button type="button" class="btn btn-sm btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> Opciones</button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item"><b>Reporte: #2221</b></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="cursor: pointer;" wire:click=""><i class="fas fa-eye"></i> Más Detalles</a>
            <a class="dropdown-item" style="cursor: pointer;" wire:click=""><i class="fas fa-arrow-alt-circle-right"></i> Asignar Refacción</a>

            <a class="dropdown-item" href="aosprint:etiqueta_refaccion#{{$item->id}}"><i class="fas fa-print"></i> Imprimir Etiqueta</a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="cursor: pointer;" onclick="destroy('Refacción','deleteRefaccion', {{$item->id}})" ><i class="fas fa-trash"></i> Eliminar</a>
        </div>
    </div>
</td>