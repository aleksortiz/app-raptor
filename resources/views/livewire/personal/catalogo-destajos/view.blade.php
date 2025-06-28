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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Personal</th>
                            <th>Total Órdenes</th>
                            <th>Monto Total</th>
                            <th>Monto Pagado</th>
                            <th>Monto Pendiente</th>
                            @if($isCurrentWeek)
                                <th>Imprimir QR</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destajos as $destajo)
                            <tr>
                                <td>{{ $destajo->nombre ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" wire:click="verOrdenes({{ $destajo->personal_id }})">
                                        {{ $destajo->total_ordenes }}
                                    </button>
                                </td>
                                <td>${{ number_format($destajo->monto_total, 2) }}</td>
                                <td>${{ number_format($destajo->monto_pagado, 2) }}</td>
                                <td>${{ number_format($destajo->monto_pendiente, 2) }}</td>
                                @if($isCurrentWeek)
                                    <td>
                                        <a href="aosprint:destajoqr#{{ $destajo->personal_id }}#{{ $weekStart }}#{{ $year }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-qrcode"></i> Código QR
                                        </a>
                                    </td>
                                @endif
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

    <!-- Modal -->
    <div class="modal fade" id="ordenesModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Órdenes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Vehículo</th>
                                    <th>Notas</th>
                                    <th>Monto</th>
                                    <th>Pagado</th>
                                    <th>Pendiente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordenesDetalle as $orden)
                                    <tr>
                                        <td>
                                            <a href="/servicios/{{ $orden['entrada_id'] }}" class="btn btn-primary btn-sm">
                                                {{ $orden['folio_short'] }}
                                            </a>
                                        </td>
                                        <td>{{ $orden['vehiculo'] }}</td>
                                        <td>{{ $orden['notas'] }}</td>
                                        <td>${{ number_format($orden['monto'], 2) }}</td>
                                        <td>${{ number_format($orden['pagado'], 2) }}</td>
                                        <td>${{ number_format($orden['pendiente'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('showModal', () => {
                $('#ordenesModal').modal('show');
            });
        });
    </script>
    @endpush
</div> 