<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPersonalDetalles">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Pagado</th>
                    <th>Pendiente</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($this->detallesPersonal ?? [] as $item)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->entrada->fecha_format}}</td>
                    <td><a href="/servicios/{{$item->entrada_id}}" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{$item->entrada->folio_short}}</a></td>
                    <td>{{$item->notas}}</td>
                    <td>@money($item->monto)</td>
                    <td>@money($item->pagado)</td>
                    <td>@money($item->pendiente)</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
