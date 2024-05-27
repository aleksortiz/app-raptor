<div class="d-inline">
    <center>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdlSelectProvider">
            <i class="fa fa-truck"></i> Selecc. Proveedor
        </button>
    </center>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectProvider">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccione Solicitudes de compra:</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#mdlSelectProvider" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col">

                            <div class="form-group m-3">
                                <label for="keyWord">Buscar</label>
                                <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Selecc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($proveedores as $item)
                                    <tr>
                                        <td>{{$item->id_paddy}}</td>
                                        <td>{{$item->nombre}}</td>
                                        <td>{{$item->direccion}}</td>
                                        <td><button class="btn btn-xs btn-success" wire:click="$emitUp('setProvider', {{$item->id}})" data-toggle="modal" data-target="#mdlSelectProvider"><i class="fa fa-check"></i> Seleccionar</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" data-toggle="modal" data-target="#mdlSelectProvider" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
                    {{$proveedores->links()}}

                </div>
            </div>
            
        </div>
    </div>
</div>
