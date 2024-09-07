@section('title', __("Vehículos Entregados"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehículos Entregados</h3>
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


                <div class="col">
                    <div class="form-group">
                        <label for="keyWord">Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <center>
                            <label for="keyWord">Cant. Vehículos</label>
                            <h2>{{ count($entradas) }}</h2>
                        </center>
                    </div>
                </div>

            </div>

            <div class="row p-2">
                <div class="col-md-3 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wrench"></i></span>
    
                    <div class="info-box-content">
                      <span class="info-box-text"><b>Refacciones</b></span>
                      <span class="info-box-number">@money($this->totalRefacciones)</span>
                    </div>

                  </div>
                </div>

                <div class="col-md-3 col-sm-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>
      
                      <div class="info-box-content">
                        <span class="info-box-text"><b>Materiales</b></span>
                        <span class="info-box-number">@money($this->totalMateriales)</span>
                      </div>

                    </div>
                </div>

                <div class="col-md-3 col-sm-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
      
                      <div class="info-box-content">
                        <span class="info-box-text"><b>Total Entradas</b></span>
                        <span class="info-box-number">@money($this->totalCostos)</span>
                      </div>

                    </div>
                </div>

                <div class="col-md-3 col-sm-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
      
                      <div class="info-box-content">
                        <span class="info-box-text"><b>Utilidad</b></span>
                        <span class="info-box-number">@money($this->totalUtilidad)</span>
                      </div>

                    </div>
                </div>

            </div>

            <table class="table table-hover">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>Origen</th>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Monto</th>
                        <th>Utilidad</th>
                        <th>Fecha de Entrega</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $row)
                    @php
                        $color = $row->porcentaje_utilidad_global < 30 ? 'text-danger' : '';
                    @endphp
                    <tr class="{{$color}}">
                        <td>{{ $loop->iteration }}</td>
                        <td><button data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-{{$row->origen_color}}"><label class="m-0 p-0">{{ $row->origen_short }}</label> </button></td>
                        <td>{{ $row->folio_short }}</td>
                        <td>{{ $row->cliente->nombre }}</td>
                        <td>{{ $row->vehiculo }}</td>
                        <td>@money($row->total)</td>
                        <td>@money($row->total_utilidad_global) (@float($row->porcentaje_utilidad_global)%)</td>
                        <td>{{ $row->fecha_entrega_format }}</td>
                        <td><a href="/servicios/{{$row->id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> Más detalles</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $entradas->links() }}

</div>
