<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Personal</h3>
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

            {{-- <button class="btn btn-xs btn-success m-2" wire:click="mdlCreate"><i class="fas fa-plus"></i> Agregar {{ $this->model_name }}</button> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Folio</th>
                        <th>Origen</th>
                        <th>Vehículo</th>
                        <th>Presupuesto M.O.</th>
                        <th>Asignado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/servicios/{{$row->model_id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{$row->folio}}</a></td>
                            <td><button data-toggle="tooltip" data-placement="top" title="{{$row->origen}}" class="btn btn-xs btn-{{$row->origen_color}}"><label class="m-0 p-0">{{ $row->origen_short }}</label> </button></td>
                            <td>{{ $row->vehiculo }}</td>
                            <td>{{$row->porcentaje_mo}}% -> @money($row->presupuesto_mo)</td>
                            <td @if($row->is_over_budget) class="text-danger" @endif>@money($row->asignado) ({{$row->porcentaje_asignado}}%)</td>
                            <td>
                                <button class="btn btn-xs btn-primary" wire:click="mdlCreate({{ $row->id }})"><i class="fas fa-plus"></i> Orden de Trabajo</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $data->links() }}

    @include('livewire.personal.admin-ordenes-trabajo.modal')

</div>
