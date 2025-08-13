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
                    <th>Descripción</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisiciones as $req)
                    <tr>
                        <td>{{ $req->id }}</td>
                        <td>{{ $req->cliente?->nombre }}</td>
                        <td>{{ Str::limit($req->descripcion, 60) }}</td>
                        <td>@money($req->monto)</td>
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
</div>
