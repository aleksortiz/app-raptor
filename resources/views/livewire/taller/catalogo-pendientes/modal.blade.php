<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCrearPendiente">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Pendiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center">

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cliente">Responsable:</label>
                            <select wire:model.defer="user_id" class="form-control" id="user_id">
                                <option value="">Seleccionar...</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                            
                        </div>

                        <div class="mt-4 form-group">
                            <label for="fecha_promesa">Fecha Promesa:<br> {{$this->tiempo_restante}}</label>
                            <input type="datetime-local" wire:model.lazy="fecha_promesa" class="form-control" id="fecha_promesa">
                            @error('fecha_promesa') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="form-group">
                            <label for="descripcion">Tarea a Realizar:</label>
                            <textarea style="resize: none;" wire:model.lazy="descripcion" class="form-control" id="descripcion" rows="6"></textarea>
                            @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>



            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="crearPendiente" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
            </div>
        </div>

    </div>

</div>
