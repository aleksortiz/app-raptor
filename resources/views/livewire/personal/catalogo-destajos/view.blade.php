<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catálogo de Destajos</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Año</label>
                        <select wire:model="year" class="form-control form-control-lg">
                            @for($i = $maxYear; $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Semana</label>
                        <select wire:model="weekStart" class="form-control form-control-lg">
                            @for($i = 1; $i <= 52; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div wire:loading wire:target="weekStart, year" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando datos...</p>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>${{ number_format($totalPendiente, 2) }}</h3>
                            <p>Total Pendiente</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>${{ number_format($totalPagado, 2) }}</h3>
                            <p>Total Pagado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Personal</th>
                            <th>Total Órdenes</th>
                            <th>Monto Total</th>
                            <th>Monto Pagado</th>
                            <th>Monto Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destajos as $destajo)
                            <tr>
                                <td>{{ $destajo->personal->nombre ?? 'N/A' }}</td>
                                <td>{{ $destajo->total_ordenes }}</td>
                                <td>${{ number_format($destajo->monto_total, 2) }}</td>
                                <td>${{ number_format($destajo->monto_pagado, 2) }}</td>
                                <td>${{ number_format($destajo->monto_pendiente, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $destajos->links() }}
            </div>
        </div>
    </div>
</div> 