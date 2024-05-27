<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectCliente">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Seleccione cliente:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="searchValueClientes">Buscar</label>
                <input type="text" wire:model.lazy="searchValueClientes" class="form-control" placeholder="Busqueda">
              </div>
              
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($clientes as $item)
                    <tr>
                      <td>{{ $item->nombre }}</td>
                      <td>{{ $item->rfc }}</td>
                      <td>{{ $item->razon_social }}</td>
                      <td>{{ $item->direccion }}</td>
                      <td>
                        <button wire:click="setCliente({{ $item->id }})" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> Seleccionar</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              {{ $clientes->links() }}
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>
    