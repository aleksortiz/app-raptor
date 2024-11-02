
@section('title', __("Catalogo Inventarios"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catalogo Inventarios</h3>
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

            <a href="/registro-inventario" class="btn btn-success btn-xs m-3"><i class="fa fa-plus"></i> Registrar Inventario</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Realizado Por:</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Ver Inventario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarios as $item)
                    <tr>
                        <td>{{ $item->id_paddy }}</td>
                        <td>{{ $item->fecha_creacion }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->cliente }}</td>
                        <td>{{ $item->vehiculo }}</td>
                        <td>
                            <a target="_blank" href="/inventarios/{{$item->id}}/pdf" class="btn btn-secondary btn-sm"><i class="fa fa-file-alt"></i> Ver Inventario</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $inventarios->links() }}

</div>
