<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPhotos">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Evaluación: #{{ $this->model->id_paddy }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Fecha Creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->model->fotos as $photo)
                                    <tr>
                                        <td><img src="{{ asset('storage/' . $photo->url) }}" alt="" width="80px"></td>
                                        <td>{{ $photo->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                </div>
                </form>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
