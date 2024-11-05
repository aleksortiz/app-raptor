

@section('title', __("Citas para Reparación"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Citas para Reparación</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <a href="/registrar-cita-reparacion" class="btn btn-success btn-xs m-3"><i class="fa fa-plus"></i> Registrar Cita</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>No Reporte</th>
                        <th>Cita</th>
                        <th>Crear Inventario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $item)
                    <tr>
                        <td>{{ $item->fecha_creacion }}</td>
                        <td>{{ $item->cliente->nombre }}</td>
                        <td>{{ $item->vehiculo }}</td>
                        <td>{{ $item->no_reporte }}</td>
                        <td>{{ $item->cita_format }}</td>
                        <td>
                            <a target="_blank" href="/registro-inventario?folioCita={{$item->id}}" class="btn btn-warning btn-sm"><i class="fa fa-file-alt"></i> Registrar Inventario</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $citas->links() }}

</div>
