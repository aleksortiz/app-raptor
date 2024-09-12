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

            {{-- <div class="row p-3">

                <div class="col">
                    <div class="form-group">
                        <label for="keyWord">Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
                    </div>
                </div>

            </div> --}}

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
                            <td>{{ $row->folio }}</td>
                            <td>{{ $row->origen }}</td>
                            <td>{{ $row->vehiculo }}</td>
                            <td>@money($row->presupuesto_mo) ({{$row->porcentaje_mo}}%)</td>
                            <td>@money($row->asignado)</td>
                            <td>
                                <button class="btn btn-xs btn-primary" wire:click="mdlCreate({{ $row->model->id }})"><i class="fas fa-plus"></i> Orden de Trabajo</button>
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
