<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->model->id ? 'Editar' : 'Agregar' }} {{ $this->model_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-8">
                            <label>Nombre</label>
                            <input wire:model.defer="model.nombre" type="text" class="form-control" required />
                            @error('model.nombre')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label>RFC</label>
                            <input wire:model.defer="model.rfc" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.rfc')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-8">
                            <label>Razón Social</label>
                            <input wire:model.defer="model.razon_social" type="text" class="form-control" required />
                            @error('model.razon_social')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-5">
                            <label>Calle</label>
                            <input wire:model.defer="model.calle" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.calle')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-2">
                            <label>Número</label>
                            <input wire:model.defer="model.numero" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.numero')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-5">
                            <label>Colonia</label>
                            <input wire:model.defer="model.colonia" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.colonia')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-2">
                            <label>Código Postal</label>
                            <input wire:model.defer="model.codigo_postal" style="text-transform: uppercase;"
                                type="text" class="form-control" required />
                            @error('model.codigo_postal')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-5">
                            <label>Ciudad</label>
                            <input wire:model.defer="model.ciudad" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.ciudad')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-5">
                            <label>Estado</label>
                            <input wire:model.defer="model.estado" style="text-transform: uppercase;" type="text"
                                class="form-control" required />
                            @error('model.estado')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->model->id)
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i
                            class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Agregar</button>
                @endif

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
