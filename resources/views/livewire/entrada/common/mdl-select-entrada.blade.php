<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Seleccione Folio:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Buscar</label>
                <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
              </div>

              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Origen</th>
                    <th>Orden</th>
                    <th>Vehículo</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($entradas as $item)
                    <tr>
                      <td><a href="/servicios/{{$item->id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{$item->folio_short}}</a></td>
                      <td><button data-toggle="tooltip" data-placement="top" title="{{$item->origen}}" class="btn btn-xs btn-{{$item->origen_color}}"><label class="m-0 p-0">{{ $item->origen_short }}</label> </button></td>
                      <td>{{ $item->orden }}</td>
                      <td>{{ $item->vehiculo }}</td>
                      <td>
                        <button wire:click="select({{ $item->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-user"></i> Seleccionar</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          {{ $entradas->links() }}

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>
