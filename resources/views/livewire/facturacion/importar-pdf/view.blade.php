<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title mb-0">Importar PDF para Facturación</h3>
            <div>
                <button class="btn btn-sm btn-secondary" wire:click="resetForm" type="button">
                    Limpiar
                </button>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="procesar">
                <div class="form-group">
                    <label for="pdf">Archivo PDF</label>
                    <input type="file" id="pdf" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf" accept="application/pdf">
                    @error('pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 d-flex align-items-center">
                    <button class="btn btn-success" type="submit" @if($isLoading) disabled @endif wire:loading.attr="disabled" wire:target="procesar">
                        <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" wire:loading wire:target="procesar"></span>
                        <span wire:loading wire:target="procesar">Procesando con IA... <i class="fa fa-robot"></i></span>
                        <span wire:loading.remove wire:target="procesar"><i class="fa fa-check"></i> Procesar</span>
                    </button>

                    <div class="ml-3 text-muted small">
                        Modelo: {{ config('openai.default_model') }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(!empty($rows))
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">Resultado</h3>
                <div>
                    <button class="btn btn-primary btn-sm" type="button" wire:click="registrarRequisiciones" wire:loading.attr="disabled" wire:target="registrarRequisiciones">
                        <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" wire:loading wire:target="registrarRequisiciones"></span>
                        <span wire:loading wire:target="registrarRequisiciones">Registrando...</span>
                        <span wire:loading.remove wire:target="registrarRequisiciones"><i class="fa fa-save"></i> Registrar requisiciones</span>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Folio</th>
                                <th>No. Reporte</th>
                                <th>Vehículo</th>
                                <th>Número de Factura</th>
                                <th class="text-right">Monto</th>
                                <th>Fecha de Pago</th>
                                <th>Notas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ $row['_entrada_url'] ?? '#' }}" target="_blank" class="btn btn-xs {{ !empty($row['_entrada_exists']) ? 'btn-primary' : 'btn-danger' }}">
                                            {{ $row['model_folio'] ?? '' }}
                                        </a>
                                    </td>
                                    <td>{{ $row['numero_reporte'] ?? ($row['_numero_reporte'] ?? '') }}</td>
                                    <td>{{ $row['numero_factura'] ?? '' }}</td>
                                    <td>{{ $row['vehiculo'] ?? '' }}</td>
                                    <td class="text-right">{{ isset($row['monto']) ? number_format((float)$row['monto'], 2, '.', ',') : '' }}</td>
                                    <td>{{ $row['fecha_pago'] ?? '' }}</td>
                                    <td>{{ $row['notas'] ?? '' }}</td>
                                    <td>
                                        @if(empty($row['_entrada_exists']))
                                            <button class="btn btn-warning btn-xs" type="button" wire:click="cambiarA24({{ $loop->index }})" wire:loading.attr="disabled" wire:target="cambiarA24({{ $loop->index }})">
                                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" wire:loading wire:target="cambiarA24({{ $loop->index }})"></span>
                                                CAMBIAR A 24
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div> 