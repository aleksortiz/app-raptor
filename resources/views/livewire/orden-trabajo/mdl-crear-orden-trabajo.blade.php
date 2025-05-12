<div class="modal fade" id="{{ $mdlName }}" tabindex="-1" role="dialog" aria-labelledby="{{ $mdlName }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $mdlName }}Label">Crear Orden de Trabajo</h5>
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
                                <input type="text" class="form-control" id="entrada" value="{{ $entrada?->folio ?? '' }}" readonly>
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
                                <label for="porcentaje">Porcentaje</label>
                                <input type="number" class="form-control @error('porcentaje') is-invalid @enderror" id="porcentaje" wire:model.defer="porcentaje" step="0.01">
                                @error('porcentaje')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notas">Notas</label>
                        <textarea class="form-control @error('notas') is-invalid @enderror" id="notas" wire:model.defer="notas" rows="3"></textarea>
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