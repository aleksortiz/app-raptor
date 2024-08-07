<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        <button wire:click="showMdlRefacciones" class="m-2 btn btn-xs btn-success"><i class="fa fa-plus"></i> Agregar Refacción</button>
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha</th>
                            <th>Número de Parte</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->evaluacion->refacciones as $item)
                        <tr>
                            <td><button class="btn btn-xs btn-danger" onclick="destroy({{$item->id}},'refacción','destroyRefaccion')"><i class="fa fa-trash-alt"></i></button></td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->numero_parte}}</td>
                            <td>{{$item->descripcion}}</td>
                            <td>@money($item->costo)</td>
                            <td>{{$item->cantidad}}</td>
                            <td>@money($item->precio)</td>
                            <td>@money($item->importe)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>