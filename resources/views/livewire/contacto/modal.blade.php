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
                        <div class="form-group col-6">
                            <label>Nombre</label>
                            <input wire:model.lazy="model.nombre" type="text" class="form-control" required />
                            @error('model.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-6">
                            <label>Correo</label>
                            <input wire:model.lazy="model.correo" type="text" class="form-control" required />
                            @error('model.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-8">
                            <label>Departamento</label>
                            <input wire:model.lazy="model.departamento" type="text" class="form-control" required />
                            @error('model.departamento') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-4">
                            <label>Prefijo</label>
                            <input wire:model.lazy="model.prefijo" type="text" class="form-control" required />
                            @error('model.prefijo') <span class="error text-danger">{{ $message }}</span> @enderror
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