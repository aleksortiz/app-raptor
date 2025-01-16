
@section('title', __("Catalogo de Valuaciones"))
<div class="pt-3">

  @livewire('valuacion.mdl-crear-valuacion')
  @livewire('cliente.common.mdl-select-cliente')

  <div class="card">
      <div class="card-header">
          <h3 class="card-title">Catalogo de Valuaciones</h3>
          <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
              </button>
          </div>
      </div>
      <div class="card-body p-0">

          <div class="row p-3">

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

          </div>

          {{-- <a href="/materiales/vales/crear-vale" class="btn btn-success btn-xs m-3"><i class="fa fa-plus"></i> Crear Vale</a> --}}
          <button class="btn btn-success btn-xs m-3" wire:click="$emit('initMdlCrearValuacion')"><i class="fa fa-plus"></i> Crear Valuación</button>
          {{-- initMdlCrearCita --}}

          <table class="table table-hover">
              <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Número de Reporte</th>
                    <th>Vehículo</th>
                    <th>Es Grua</th>
                    <th>Fecha de Cita</th>
                    <th>Valuación Efectuada</th>
                    <th>Entrada</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($valuaciones as $item)
                  <tr style="cursor: pointer" onclick="window.location.href='/valuaciones/{{ $item->id }}'">
                      <td>{{ $item->fecha_creacion }}</td>
                      <td>{{ $item->numero_reporte }}</td>
                      <td>{{ $item->vehiculo }}</td>
                      <td>{!! $item->grua_span !!}</td>
                      <td>{!! $item->fecha_cita_span !!}</td>
                      <td>{!! $item->estado_span !!}</td>
                      <td>{!! $item->entrada_span !!}</td>
                  </tr>
                  @endforeach
              </tbody>
          </table>

      </div>
  </div>
  {{ $valuaciones->links() }}

</div>
