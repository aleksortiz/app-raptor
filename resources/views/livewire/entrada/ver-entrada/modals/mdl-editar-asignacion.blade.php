<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl-editar-asignacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Asignación de Trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="actualizar">
                    <div class="form-group">
                        <label for="personal_id">Personal</label>
                        <select class="form-control @error('personal_id') is-invalid @enderror" wire:model.defer="personal_id">
                            <option value="">Seleccione al personal</option>
                            @foreach($personal_list as $persona)
                                <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                            @endforeach
                        </select>
                        @error('personal_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion_trabajo">Descripción del Trabajo</label>
                        <textarea class="form-control @error('descripcion_trabajo') is-invalid @enderror" 
                                wire:model.defer="descripcion_trabajo" 
                                rows="3"
                                style="resize: none;"
                                placeholder="Describe el trabajo a realizar"></textarea>
                        @error('descripcion_trabajo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control @error('estado') is-invalid @enderror" wire:model.defer="estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="completado">Completado</option>
                        </select>
                        @error('estado') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" x-show="$wire.estado === 'completado'">
                        <label for="fecha_realizado">Fecha de Realización</label>
                        <input type="datetime-local" 
                               class="form-control @error('fecha_realizado') is-invalid @enderror" 
                               wire:model.defer="fecha_realizado">
                        @error('fecha_realizado') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="actualizar"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>
