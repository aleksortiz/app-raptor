<div>
    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vehículos Terminados</span>
                    <span class="info-box-number">{{ $totalTerminados }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-check-double"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vehículos Entregados</span>
                    <span class="info-box-number">{{ $totalEntregados }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Vehículos</span>
                    <span class="info-box-number">{{ $totalVehiculos }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-2">
            <div class="form-group">
                <label>Año</label>
                <select wire:model="year" class="form-control form-control-sm">
                    @for($i = $maxYear; $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Semana</label>
                <select wire:model="weekStart" class="form-control form-control-sm">
                    @for($i = 1; $i <= 52; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vehículos Concluidos y Entregados</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" wire:model="keyWord" class="form-control float-right" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Vehículo</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Utilidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entradas as $entrada)
                            <tr>
                                <td>{!! $entrada->folio_button !!}</td>
                                <td>{{ $entrada->vehiculo }}</td>
                                <td>{{ $entrada->cliente->nombre }}</td>
                                <td>
                                    @if($entrada->fecha_entrega && Carbon\Carbon::parse($entrada->fecha_entrega)->between($start, $end))
                                        <span class="badge badge-success">ENTREGADO</span>
                                    @elseif($entrada->avance && $entrada->avance->terminado && Carbon\Carbon::parse($entrada->avance->terminado)->between($start, $end))
                                        <span class="badge badge-info">TERMINADO</span>
                                    @endif
                                </td>
                                <td>
                                    @if($entrada->fecha_entrega && Carbon\Carbon::parse($entrada->fecha_entrega)->between($start, $end))
                                        {{ Carbon\Carbon::parse($entrada->fecha_entrega)->format('M/d/y h:i A') }}
                                    @elseif($entrada->avance && $entrada->avance->terminado && Carbon\Carbon::parse($entrada->avance->terminado)->between($start, $end))
                                        {{ Carbon\Carbon::parse($entrada->avance->terminado)->format('M/d/y h:i A') }}
                                    @endif
                                </td>
                                <td>${{ number_format($entrada->total, 2) }}</td>
                                <td class="{{ $entrada->porcentaje_utilidad_global < 30 ? 'text-danger' : '' }}">
                                    ${{ number_format($entrada->total_utilidad_global, 2) }}
                                    ({{ number_format($entrada->porcentaje_utilidad_global, 2) }}%)
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Total Materiales:</strong> ${{ number_format($totalMateriales, 2) }}
                        </div>
                        <div class="col-md-4">
                            <strong>Total Entradas:</strong> ${{ number_format($totalCostos, 2) }}
                        </div>
                        <div class="col-md-4">
                            <strong>Total Utilidad:</strong> ${{ number_format($totalUtilidad, 2) }}
                            ({{ $porcentajeUtilidad }}%)
                        </div>
                    </div>
                    {{ $entradas->links() }}
                </div>
            </div>
        </div>
    </div>
</div> 