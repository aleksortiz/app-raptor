@section('title', __($this->model_name_plural))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catalogo de {{ $this->model_name_plural }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row p-3">

                <div class="col-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <label class="content-input">
                            <input wire:model.live="filtroEnPiso" type="checkbox" id="filtroEnPiso">
                            <i></i>
                            <span class="ml-2">Solo en piso</span>
                        </label>
                    </div>
                </div>
                
                <div class="col-1 {{ $filtroEnPiso ? 'd-none' : '' }}">
                    <div class="form-group">
                        <label for="keyWord">Año</label>
                        <select wire:model.lazy="year" class="form-control" id="year">
                            @foreach (range(2021, $this->maxYear) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-1 {{ $filtroEnPiso ? 'd-none' : '' }}">
                    <div class="form-group">
                        <label for="keyWord">Semana</label>
                        <select wire:model.lazy="weekStart" class="form-control" id="weekStart">
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                
                <div class="col-1 {{ $filtroEnPiso ? 'd-none' : '' }}">
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
                        <label for="keyWord">Origen</label>
                        <select wire:model.lazy="origen" class="form-control" id="origen">
                            <option value="">Todos</option>
                            <option value="PARTICULAR">PARTICULAR</option>
                            <option value="ASEGURADORA">ASEGURADORA</option>
                            <option value="AGENCIA">AGENCIA</option>
                            <option value="GARANTIA">GARANTIA</option>
                        </select>
                    </div>
                </div>

            </div>

            @canany(['administrar-materiales'])
                <a href="/crear-entrada" target="_blank" class="btn btn-xs btn-primary m-2"><i class="fas fa-plus"></i> Agregar {{ $this->model_name }}</a>
            @endcanany

            <a type="button" href="/vehiculos-piso/excel" class="btn btn-xs btn-success"><i class="fas fa-file-excel"></i> Vehiculos en piso </a>

            @if($entregasHoy->count() > 0)
                <div class="card mt-3">
                    <div class="card-header bg-warning">
                        <h4 class="text-center"><b>ENTREGAS DE HOY</b></h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Folio</th>
                                    <th>Origen</th>
                                    <th>Cliente</th>
                                    <th>No. Reporte</th>
                                    <th>Vehículo</th>
                                    <th>Monto</th>
                                    {{-- <th>Asignaciones</th> --}}
                                    <th>Ordenes de Trabajo</th>
                                    <th>Estatus</th>
                                    <th>Se entrega Hoy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entregasHoy as $row)
                                <tr>
                                    <td>
                                        <a href="/servicios/{{$row->id}}?activeTab=3"><img src="{{ $row->main_photo }}" class="img-fluid" alt="image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 10%; border: solid 1px #ddd;"></a>
                                    </td>
                                    <td><a href="/servicios/{{$row->id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{$row->folio_short}}</a></td>
                                    <td><button data-toggle="tooltip" data-placement="top" title="{{$row->origen}}" class="btn btn-xs btn-{{$row->origen_color}}"><label class="m-0 p-0">{{ $row->origen_short }}</label> </button></td>
                                    <td>{{ $row->cliente->nombre }}</td>
                                    <td>{{ $row->orden ? $row->orden : "N/A" }}</td>
                                    <td>{{ $row->vehiculo }}</td>
                                    <td>@money($row->total)</td>
                                    {{-- <td>
                                        <a href="/servicios/{{$row->id}}?activeTab=10" class="btn btn-xs btn-{{ $row->asignaciones->count() > 0 ? 'success' : 'secondary' }}">
                                            <i class="fas fa-tasks"></i> {{ $row->asignaciones->count() }}
                                        </a>
                                    </td> --}}
                                    <td>
                                        <button wire:click="showMdlCrearOrdenTrabajo({{ $row->id }})" class="btn btn-xs btn-{{ $row->ordenesTrabajo->count() > 0 ? 'success' : 'secondary' }}">
                                            <i class="fas fa-clipboard-list"></i> {{ $row->ordenesTrabajo->count() }}
                                        </button>
                                    </td>
                                    <td>{!! $row->estado_button !!}</td>
                                    <td>
                                        <label class="content-input">
                                            <input type="checkbox" wire:click="toggleProyeccion({{$row->id}})" {{ $row->proyeccion_entrega ? 'checked' : '' }}>
                                            <i></i>
                                        </label>
                                        @if($row->proyeccion_entrega)
                                            <small class="text-muted d-block">{{ \Carbon\Carbon::parse($row->proyeccion_entrega)->format('d/m/Y') }}</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $entregasHoy->links() }}
            @endif

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Otras Entradas</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Folio</th>
                                <th>Origen</th>
                                <th>Cliente</th>
                                <th>No. Reporte</th>
                                <th>Vehículo</th>
                                <th>Monto</th>
                                <th>Ordenes de Trabajo</th>
                                <th>Estatus</th>
                                <th>Proyección de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($otrasEntradas as $row)
                            <tr>
                                <td>
                                    <a href="/servicios/{{$row->id}}?activeTab=3"><img src="{{ $row->main_photo }}" class="img-fluid" alt="image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 10%; border: solid 1px #ddd;"></a>
                                </td>
                                <td><a href="/servicios/{{$row->id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{$row->folio_short}}</a></td>
                                <td><button data-toggle="tooltip" data-placement="top" title="{{$row->origen}}" class="btn btn-xs btn-{{$row->origen_color}}"><label class="m-0 p-0">{{ $row->origen_short }}</label> </button></td>
                                <td>{{ $row->cliente->nombre }}</td>
                                <td>{{ $row->orden ? $row->orden : "N/A" }}</td>
                                <td>{{ $row->vehiculo }}</td>
                                <td>@money($row->total)</td>
                                <td>
                                    <button wire:click="showMdlCrearOrdenTrabajo({{ $row->id }})" class="btn btn-xs btn-{{ $row->ordenesTrabajo->count() > 0 ? 'success' : 'secondary' }}">
                                        <i class="fas fa-clipboard-list"></i> {{ $row->ordenesTrabajo->count() }}
                                    </button>
                                </td>
                                <td>{!! $row->estado_button !!}</td>
                                <td>
                                    <label class="content-input">
                                        <input type="checkbox" wire:click="toggleProyeccion({{$row->id}})" {{ $row->proyeccion_entrega ? 'checked' : '' }}>
                                        <i></i>
                                    </label>
                                    @if($row->proyeccion_entrega)
                                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($row->proyeccion_entrega)->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $otrasEntradas->links() }}

        </div>
    </div>

    @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
    @include('livewire.entrada.catalogo-entradas.modal-pago-servicios')
    @include('livewire.entrada.catalogo-entradas.modal-edit-proyeccion-entrega')

    @livewire('orden-trabajo.mdl-crear-orden-trabajo')

</div>
