<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Seleccione Personal:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div class="form-group">
                <label>Buscar</label>
                <input type="text" wire:model.lazy="searchValue" class="form-control" placeholder="Busqueda">
              </div>

              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($personal as $persona)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $persona->nombre }}</td>
                      <td>
                        <button wire:click="select({{ $persona->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-user"></i> Seleccionar</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          {{ $personal->links() }}

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>
