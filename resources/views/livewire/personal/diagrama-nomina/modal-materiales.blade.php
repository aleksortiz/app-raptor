<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlDetalleMaterial">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Listado de Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Material</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($this->materiales as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$this->fecha_creacion($item->created_at)}}</td>
                                <td>
                                    <a target="_blank" href="/servicios/{{$item->id}}?activeTab=6" class="btn btn-xs btn-warning"><i class="fas fa-car"></i> {{$item->entrada->folio_short}}</a>
                                </td>
                                <td>{{$item->material}}</td>
                                <td>{{$item->unidad_medida}}</td>
                                <td>{{$item->cantidad}}</td>
                                <td>@money($item->precio)</td>
                                <td>@money($item->importe)</td>
                            </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
