
@section('title', __("Vales de Materiales"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vales de Materiales</h3>
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

            <a href="/materiales/vales/crear-vale" class="btn btn-success btn-xs m-3"><i class="fa fa-plus"></i> Crear Vale</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Personal</th>
                        <th>Autoriza</th>
                        <th>Ver Vale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vales as $item)
                    <tr>
                        <td>{{ $item->id_paddy }}</td>
                        <td>{{ $item->fecha_creacion }}</td>
                        <td>{{ $item->personal->nombre }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            <a target="_blank" href="/materiales/vales/{{$item->id}}/pdf" class="btn btn-secondary btn-sm"><i class="fa fa-ticket-alt"></i> Ver Vale</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $vales->links() }}

</div>
