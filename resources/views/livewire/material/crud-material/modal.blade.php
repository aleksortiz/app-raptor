<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->model->id ? "Editar" : "Agregar"}} {{$this->model_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Número de Parte</label>
                            <input wire:model.defer="model.numero_parte" style="text-transform: uppercase;" type="text" class="form-control" required />
                            @error('model.numero_parte') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-8">
                            <label>Categoria</label>
                            <input wire:model.defer="model.categoria" style="text-transform: uppercase;" type="text" class="form-control" required />
                            @error('model.categoria') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-9">
                            <label>Descripción</label>
                            <input wire:model.defer="model.descripcion" type="text" class="form-control" required />
                            @error('model.descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-3">
                            <label>Unidad de Medida</label>
                            <input wire:model.defer="model.unidad_medida" type="text" class="form-control" style="text-align: center; text-transform: uppercase;" />
                            @error('model.unidad_medida') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-3">
                            <label>Precio</label>
                            <input wire:model.defer="model.precio" type="text" class="form-control" style="text-align: right;" />
                            @error('model.precio') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-3">
                            <label>Existencia</label>
                            <input wire:model.defer="model.existencia"  type="text" class="form-control" style="text-align: center" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                            @error('model.existencia') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label>Comentarios</label>
                            <textarea class="form-control" wire:model.defer="model.comentarios"></textarea>
                            @error('model.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->model->id)
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>