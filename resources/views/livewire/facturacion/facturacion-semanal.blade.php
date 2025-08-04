<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4><i class="fas fa-file-invoice-dollar mr-2"></i> Facturación Semanal</h4>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="btn-group">
                        <button wire:click="previousWeek" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-light">
                            Semana {{ $weekNumber }} ({{ $startDate }} - {{ $endDate }})
                        </button>
                        <button wire:click="nextWeek" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="year">Año</label>
                        <select wire:model="year" id="year" class="form-control">
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}">{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="weekNumber">Semana</label>
                        <select wire:model="weekNumber" id="weekNumber" class="form-control">
                            @for($i = 1; $i <= 53; $i++)
                                <option value="{{ $i }}">Semana {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filterStatus">Estado</label>
                        <select wire:model="filterStatus" id="filterStatus" class="form-control">
                            <option value="all">Todos</option>
                            <option value="pagado">Pagados</option>
                            <option value="pendiente">Pendientes</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="searchTerm">Buscar</label>
                        <input wire:model.debounce.300ms="searchTerm" type="text" class="form-control" placeholder="Factura, folio...">
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Facturado</h5>
                            <h3 class="mb-0">${{ number_format($totalMonto, 2) }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pagado</h5>
                            <h3 class="mb-0">${{ number_format($totalPagado, 2) }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pendiente</h5>
                            <h3 class="mb-0">${{ number_format($totalPendiente, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Factura</th>
                            <th>Servicio/Modelo</th>
                            <th>Folio</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Fecha Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas as $factura)
                            <tr>
                                <td>{{ $factura->numero_factura }}</td>
                                <td>{!! $factura->model_span !!}</td>
                                <td>
                                    @if($factura->model_type == 'App\\Models\\Entrada')
                                        {{ $factura->model->folio ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-right">${{ number_format($factura->monto, 2) }}</td>
                                <td>
                                    @if($factura->pagado)
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Pagado</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    {!! $factura->fecha_pago_span !!}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button wire:click="markAsPaid({{ $factura->id }})" class="btn btn-sm {{ $factura->pagado ? 'btn-danger' : 'btn-success' }}">
                                            @if($factura->pagado)
                                                <i class="fas fa-times"></i> Marcar no pagado
                                            @else
                                                <i class="fas fa-check"></i> Marcar pagado
                                            @endif
                                        </button>
                                        
                                        <button wire:click="selectFactura({{ $factura->id }})" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#{{ $modalId }}">
                                            <i class="fas fa-sticky-note"></i> Notas
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle mr-2"></i> No se encontraron facturas para esta semana
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $facturas->links() }}
            </div>
        </div>
    </div>
    
    <!-- Modal para editar notas -->
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{ $modalId }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($selectedFactura)
                            Notas - Factura {{ $selectedFactura->numero_factura }}
                        @else
                            Notas
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="notas">Notas:</label>
                        <div wire:key="textarea-{{ $selectedFactura ? $selectedFactura->id : 'new' }}">
                            <textarea wire:model.lazy="notas" id="notas" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click="saveNotas" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
