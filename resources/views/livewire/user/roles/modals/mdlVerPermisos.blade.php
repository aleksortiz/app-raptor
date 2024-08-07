<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlVerPermisos">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permisos de: {{$model->name_format}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model->permissions as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{strtoupper(str_replace('-', ' ', $item->name))}}</td>
                            <td>{{$permission_details[$item->name]}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
     
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>