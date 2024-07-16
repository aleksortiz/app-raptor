@section('title', __('Pedidos'))
<div class="pt-3">
    <div style="min-height: 85vh" class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $this->model_name_plural }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row pl-3 pt-3">

                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Año</label>
                        <select wire:model.lazy="year" class="form-control" id="year">
                            @foreach (range(2021, $this->maxYear) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Semana</label>
                        <select wire:model.lazy="weekStart" class="form-control" id="weekStart">
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">a la</label>
                        <select wire:model.lazy="weekEnd" class="form-control" id="weekEnd">
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                  <div class="info-box" style="cursor: pointer;">
                      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck"></i></span>
  
                      <div class="info-box-content">
                          <span class="info-box-text"><b>Total Pedidos</b></span>
                          <span class="info-box-number">@money($data->sum('total'))</span>
                      </div>
  
                  </div>
                </div>

            </div>


            <div class="ml-3">
                <a href="/materiales/crear-pedido" target="_blank" class="btn btn-xs btn-primary"><i
                        class="fa fa-plus"></i> Crear Pedido</a>
            </div>


            <table class="mt-3 table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Importe</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id_paddy }}</td>
                            <td>{{ $row->fecha_creacion }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->proveedor->nombre }}</td>
                            <td>@money($row->total)</td>
                            <td>{{ $row->estatus_recibido }}</td>
                            <td>
                                @can('enviar-pedidos')
                                    <button wire:click="mdlEnviarCorreo({{ $row->id }})"
                                        class="btn btn-xs btn-warning"><i class="fa fa-envelope"></i> Enviar Pedido</button>
                                @endcan
                                <a href='/materiales/pedido_pdf/{{ $row->id }}' target="_blank"
                                    class="btn btn-xs btn-primary"><i class="fa fa-file-alt"></i> Ver Pedido</a>
                                <button wire:click="$emit('initMdlRecibirPedido',{{ $row }})"
                                    class="btn btn-xs btn-success"><i class="fa fa-truck"></i> Recibir Pedido</button>
                            </td>
                        <tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $data->links() }}
</div>
