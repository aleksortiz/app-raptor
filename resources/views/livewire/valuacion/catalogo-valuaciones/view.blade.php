@section('title', __("Catalogo de Valuaciones"))
<div class="pt-3">

  @livewire('valuacion.mdl-crear-valuacion')
  @include('livewire.valuacion.catalogo-valuaciones.modal-cita-reparacion')
  @include('livewire.valuacion.catalogo-valuaciones.modal-crear-entrada')

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



              <div class="col-1" @if(!empty($search)) style="display: none;" @endif>
                  <div class="form-group">
                      <label for="keyWord">Año</label>
                      <select wire:model.lazy="year" class="form-control" id="year">
                          @foreach (range(2021, $this->maxYear) as $item)
                              <option value="{{ $item }}">{{ $item }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-1" @if(!empty($search)) style="display: none;" @endif>
                  <div class="form-group">
                      <label for="keyWord">Semana</label>
                      <select wire:model.lazy="start" class="form-control" id="start">
                          @foreach (range(1, 52) as $item)
                              <option value="{{ $item }}">{{ $item }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-1" @if(!empty($search)) style="display: none;" @endif>
                  <div class="form-group">
                      <label for="keyWord">a la</label>
                      <select wire:model.lazy="end" class="form-control" id="end">
                          @foreach (range(1, 52) as $item)
                              <option value="{{ $item }}">{{ $item }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="search">Búsqueda</label>
                    <input wire:model.lazy="search" type="text" class="form-control" id="search" placeholder="Buscar por folio, reporte o vehículo...">
                </div>
            </div>

          </div>

          <button class="btn btn-success btn-xs m-3" wire:click="$emit('initMdlCrearValuacion')"><i class="fa fa-plus"></i> Crear Valuación</button>

          <table class="table table-hover">
              <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Número de Reporte</th>
                    <th>Vehículo</th>
                    <th>Es Grua</th>
                    <th>Pago de Daños</th>
                    <th>Fecha de Cita</th>
                    <th>Valuación Efectuada</th>
                    <th>Opciones</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($valuaciones as $item)
                    <tr style="cursor: pointer">
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">
                                <img src="{{ $item->main_photo }}" class="img-fluid" alt="image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 10%; border: solid 1px #ddd;">
                            </td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{{ $item->fecha_creacion }}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{{ $item->id_paddy }}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{{ $item->numero_reporte }}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{{ $item->vehiculo }}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{!! $item->grua_span !!}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{!! $item->pago_danos_span !!}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{!! $item->fecha_cita_span !!}</td>
                            <td onclick="window.location.href='/valuaciones/{{ $item->id }}'">{!! $item->estado_span !!}</td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> Opciones</button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item"><b>Valuación: #{{ $item->id_paddy }}</b></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='/valuaciones/{{ $item->id }}'"><i class="fas fa-eye"></i> Ver Detalles</a>
                                        <a class="dropdown-item" style="cursor: pointer;" wire:click="crearCitaReparacion({{ $item->id }})"><i class="fas fa-calendar-plus"></i> Crear Cita a Reparación</a>
                                        <a class="dropdown-item" style="cursor: pointer;" wire:click="crearEntrada({{ $item->id }})"><i class="fas fa-clipboard-check"></i> Crear Entrada</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/valuaciones/{{ $item->id }}/print" target="_blank"><i class="fas fa-print"></i> Imprimir Valuación</a>
                                    </div>
                                </div>
                            </td>
                    </tr>
                  @endforeach
              </tbody>
          </table>

      </div>
  </div>
  {{ $valuaciones->links() }}

</div>
