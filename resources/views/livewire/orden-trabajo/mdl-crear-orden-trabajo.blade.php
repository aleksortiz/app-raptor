<div wire:ignore.self class="modal fade" id="{{ $mdlName }}" tabindex="-1" role="dialog" aria-labelledby="{{ $mdlName }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $mdlName }}Label">Registrar Destajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="create">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="entrada">Entrada</label>
                                <input type="text" class="form-control" id="entrada" value="{{ $entrada?->folio_short . ' - ' . $entrada?->vehiculo }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal">Personal</label>
                                <select class="form-control @error('personal_id') is-invalid @enderror" id="personal" wire:model.defer="personal_id">
                                    <option value="">Seleccione un personal</option>
                                    @foreach($personal as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('personal_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="monto">Monto</label>
                                <input type="number" class="form-control @error('monto') is-invalid @enderror" id="monto" wire:model.defer="monto" step="0.01">
                                @error('monto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                @if($verOtrosDestajosUrl)
                                    <a href="{{ $verOtrosDestajosUrl }}" class="btn btn-success btn-block">
                                        Ver otros destajos ({{ $destajosCount }})
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Componentes y Acciones</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Componente</th>
                                        @foreach($acciones as $accion)
                                            <th class="text-center">{{ $accion }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($componentes as $componente)
                                        <tr>
                                            <td>{{ $componente }}</td>
                                            @foreach($acciones as $accion)
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" 
                                                               class="custom-control-input" 
                                                               id="check_{{ $componente }}_{{ $accion }}"
                                                               wire:model="selecciones.{{ $componente }}.{{ $accion }}">
                                                        <label class="custom-control-label" for="check_{{ $componente }}_{{ $accion }}"></label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notas">Notas Generadas</label>
                        <textarea class="form-control @error('notas') is-invalid @enderror" id="notas" wire:model="notas" rows="3" readonly></textarea>
                        @error('notas')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 