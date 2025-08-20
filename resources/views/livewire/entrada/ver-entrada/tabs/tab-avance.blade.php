<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        @livewire('entrada.captura-avance-entrada', ['id' => $entrada->id])

        @if($entrada->estado === 'TERMINADO')
            <div class="mt-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-invoice-dollar mr-2"></i> Requisición de Factura</h3>
                    </div>
                    <div class="card-body">
                        <p>El vehículo está <strong>TERMINADO</strong>. Puede generar una requisición de factura.</p>
                        <button type="button" class="btn btn-primary" wire:click="iniciarCreacionRequisicion">
                            <i class="fas fa-plus mr-1"></i> Generar Requisición de Factura
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Listado de Requisiciones Existentes -->
        @if($entrada->requisiciones_factura && $entrada->requisiciones_factura->count() > 0)
            <div class="mt-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-list mr-2"></i> Requisiciones de Factura Existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Aseguradora</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entrada->requisiciones_factura as $req)
                                    <tr>
                                        <td>{{ $req->id }}</td>
                                        <td>{{ $req->nombre_cliente }}</td>
                                        <td>{{ $req->aseguradora }}</td>
                                        <td>@money($req->monto)</td>
                                        <td>
                                            @php
                                                $hasFactura = !empty($req->numero_factura);
                                                $hasPago = !empty($req->fecha_pago);
                                            @endphp
                                            @if (!$hasFactura)
                                                <button type="button" class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> PENDIENTE</button>
                                            @elseif ($hasFactura && !$hasPago)
                                                <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-file-invoice"></i> FACTURADO</button>
                                            @else
                                                <button type="button" class="btn btn-xs btn-success"><i class="fa fa-check"></i> PAGADO</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('facturacion.requisicion.ver', $req->id) }}" class="btn btn-xs btn-info" target="_blank">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
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
</div>

<!-- Modal para crear requisición -->
<div wire:ignore.self class="modal fade" id="mdlCreateRequisicion" tabindex="-1" aria-labelledby="mdlCreateRequisicionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlCreateRequisicionLabel">Generar Requisición de Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="aseguradora">Facturar a:</label>
                    <select class="form-control" id="aseguradora" wire:model.defer="requisicionData.aseguradora" required>
                        <option value="">Seleccione...</option>
                        <option value="QUALITAS">QUALITAS</option>
                        <option value="CENTAURO">CENTAURO</option>
                        <option value="AUTOS JUVENTUD CHIHUAHUA">AUTOS JUVENTUD CHIHUAHUA</option>
                        <option value="TU MEJOR AGENCIA">TU MEJOR AGENCIA</option>
                        <option value="PARTICULAR">PARTICULAR</option>
                    </select>
                    @error('requisicionData.aseguradora') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if(isset($requisicionData['aseguradora']) && $requisicionData['aseguradora'] === 'PARTICULAR')
                <div class="form-group">
                    <label>Cliente de la entrada</label>
                    <input type="text" class="form-control" value="{{ $entrada->cliente?->nombre ?? 'SIN CLIENTE' }}" readonly>
                </div>
                @if($this->clienteNecesitaConstanciaFiscal)
                <div class="form-group">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> El cliente no tiene documento "CONSTANCIA FISCAL". Cárguelo para continuar.
                    </div>
                    <label>Subir CONSTANCIA FISCAL (PDF/Imagen, máx 10MB)</label>
                    <input type="file" class="form-control-file" wire:model="constanciaFiscalFile" accept="application/pdf,image/*">
                    @error('constanciaFiscalFile') <span class="text-danger">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="constanciaFiscalFile" class="text-muted mt-1"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>
                </div>
                @endif
                @endif
                <div class="form-group">
                    <label for="monto">Monto:</label>
                    <input type="number" step="0.01" class="form-control" id="monto" wire:model.defer="requisicionData.monto" required>
                    @error('requisicionData.monto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" wire:model.defer="requisicionData.descripcion" rows="3" required></textarea>
                    @error('requisicionData.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" wire:click="crearRequisicion" class="btn btn-primary">Generar Requisición</button>
            </div>
        </div>
    </div>
</div>
