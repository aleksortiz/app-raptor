<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h3><i class="fas fa-clipboard-check"></i> Valuaciones</h3>
                <hr>
                
                @if($entrada->valuaciones && $entrada->valuaciones->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Vehículo</th>
                                    <th>Reporte</th>
                                    <th>Fecha</th>
                                    <th>Presupuesto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entrada->valuaciones as $valuacion)
                                    @php
                                        $presupuesto = $valuacion->presupuestos->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $valuacion->id }}</td>
                                        <td>{{ $valuacion->cliente->nombre ?? 'N/A' }}</td>
                                        <td>{{ $valuacion->vehiculo }}</td>
                                        <td>{{ $valuacion->numero_reporte }}</td>
                                        <td>{{ \Carbon\Carbon::parse($valuacion->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($presupuesto)
                                                ${{ number_format($presupuesto->total, 2) }}
                                            @else
                                                Sin presupuesto
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/valuaciones/{{ $valuacion->id }}" class="btn btn-xs btn-info">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                @if($presupuesto)
                                                    <a href="/presupuestos/{{ $presupuesto->id }}/pdf?pago_danos={{ $valuacion->pago_danos }}" class="btn btn-xs btn-danger">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                    <a href="/presupuestos/{{ $presupuesto->id }}/excel?pago_danos={{ $valuacion->pago_danos }}" class="btn btn-xs btn-success">
                                                        <i class="fas fa-file-excel"></i> Excel
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay valuaciones registradas para esta entrada.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
