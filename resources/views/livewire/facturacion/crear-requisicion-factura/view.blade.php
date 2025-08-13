<div>
    <div class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <label>Buscar</label>
                <input type="text" wire:model.lazy="searchKey" class="form-control" placeholder="Buscar por cliente, factura, descripción...">
            </div>
            <div class="col-md-9 d-flex align-items-end justify-content-end">
                <button class="btn btn-primary btn-sm" wire:click="openCreate"><i class="fa fa-plus"></i> Nueva Requisición</button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Entrada</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisiciones as $req)
                    <tr>
                        <td>{{ $req->id }}</td>
                        <td>{{ $req->cliente?->nombre }}</td>
                        <td>
                            @if ($req->model_type === \App\Models\Entrada::class && $req->model_id)
                                {!! optional(\App\Models\Entrada::find($req->model_id))->folio_button !!}
                            @else
                                <span class="badge badge-secondary">SIN ENTRADA</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($req->descripcion, 60) }}</td>
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
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> Opciones</button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item"><b>Req: #{{ $req->id }}</b></a>
                                    <div class="dropdown-divider"></div>
                                    @if (!$hasFactura)
                                        <a class="dropdown-item" style="cursor: pointer;" wire:click="openCapturaFactura({{ $req->id }})"><i class="fas fa-file-invoice"></i> Capturar Factura y Pago</a>
                                        <a class="dropdown-item text-danger" style="cursor: pointer;" onclick="destroy({{ $req->id }}, 'Requisición #{{ $req->id }}', 'deleteRequisicion')"><i class="fas fa-trash"></i> Eliminar</a>
                                    @elseif ($hasFactura && !$hasPago)
                                        <a class="dropdown-item" style="cursor: pointer;" wire:click="openCapturaPago({{ $req->id }})"><i class="fas fa-dollar-sign"></i> Registrar Pago</a>
                                    @else
                                        <a class="dropdown-item disabled"><i class="fas fa-check"></i> Sin acciones</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $requisiciones->links() }}
    </div>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlNameCreate}}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Requisición</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label>Cliente</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $selectedClienteNombre }}" placeholder="Sin seleccionar" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm" wire:click="$emit('initMdlSelectCliente')" @if($selectedEntradaFolio) disabled @endif><i class="fa fa-user"></i></button>
                                    <button class="btn btn-danger btn-sm" title="Quitar cliente" wire:click="clearCliente" @if(!$selectedClienteNombre) disabled @endif><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            @error('requisicion.cliente_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Entrada seleccionada</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $selectedEntradaFolio }}" placeholder="Ninguna" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" wire:click="$emit('showModal', '#mdlSelectEntrada')" @if($requisicion->cliente_id) disabled @endif><i class="fa fa-car"></i></button>
                                    <button class="btn btn-danger btn-sm" title="Quitar entrada" wire:click="clearEntrada" @if(!$selectedEntradaFolio) disabled @endif><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Uso CFDI</label>
                            <select class="form-control" wire:model.defer="requisicion.uso_cfdi">
                                <option value="">Seleccione...</option>
                                @foreach ($usoCfdiOptions as $key => $label)
                                    <option value="{{$key}}">{{$key}} - {{$label}}</option>
                                @endforeach
                            </select>
                            @error('requisicion.uso_cfdi') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Forma de Pago</label>
                            <select class="form-control" wire:model.defer="requisicion.forma_pago">
                                <option value="">Seleccione...</option>
                                @foreach ($formasPagoOptions as $key => $label)
                                    <option value="{{$key}}">{{$key}} - {{$label}}</option>
                                @endforeach
                            </select>
                            @error('requisicion.forma_pago') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Monto</label>
                            <input type="number" step="0.01" class="form-control" wire:model.defer="requisicion.monto">
                            @error('requisicion.monto') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            @if ($clienteNecesitaConstanciaFiscal)
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i> El cliente no tiene documento "CONSTANCIA FISCAL". Cárguelo para continuar.
                                </div>
                                <label>Subir CONSTANCIA FISCAL (PDF/Imagen, máx 10MB)</label>
                                <input type="file" class="form-control-file" wire:model="constanciaFiscalFile" accept="application/pdf,image/*">
                                @error('constanciaFiscalFile') <span class="error text-danger">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="constanciaFiscalFile" class="text-muted mt-1"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Conceptos de Facturación</label>
                            <textarea class="form-control" rows="5" wire:model.defer="requisicion.descripcion"></textarea>
                            @error('requisicion.descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button type="button" class="btn btn-success" wire:click="save"><i class="fas fa-check"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    @livewire('cliente.common.mdl-select-cliente')
    @livewire('entrada.common.mdl-select-entrada', ['emitAction' => 'setEntrada'])

    <!-- Modal Captura Factura/Pago -->
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlNameFactura}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Capturar Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Número de Factura</label>
                        <input type="text" class="form-control" wire:model.defer="numeroFactura">
                        @error('numeroFactura') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Fecha de Pago (opcional)</label>
                        <input type="date" class="form-control" wire:model.defer="fechaPago">
                        @error('fechaPago') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button type="button" class="btn btn-success" wire:click="saveCapturaFactura"><i class="fas fa-check"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Captura Pago -->
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlNamePago}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fecha de Pago</label>
                        <input type="date" class="form-control" wire:model.defer="fechaPago">
                        @error('fechaPago') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button type="button" class="btn btn-success" wire:click="saveCapturaPago"><i class="fas fa-check"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
