<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectProveedor">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Seleccione proveedor:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group m-3">
                <label for="searchValueClientes">Buscar</label>
                <input type="text" wire:model.lazy="searchValueProveedor" class="form-control" placeholder="Busqueda">
              </div>
              
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($proveedores as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->nombre }}</td>
                      <td>{{ $item->razon_social }}</td>
                      <td>{{ $item->direccion }}</td>
                      <td>{{ $item->ciudad }}</td>
                      <td>{{ $item->estado }}</td>
                      <td>
                        <button wire:click="setProveedor({{ $item->id }})" class="btn btn-xs btn-secondary"><i class="fa fa-truck"></i> Seleccionar</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
  
              {{ $proveedores->links() }}
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>
    