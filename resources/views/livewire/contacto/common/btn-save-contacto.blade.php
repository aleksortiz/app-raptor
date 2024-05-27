<div class="d-inline">
    <button class="btn btn-xs {{$btn_color}}" data-toggle="modal" data-target="#mdlCreateContacto">
        <i class='fa {{$btn_icon}}'></i> {{$btn_text}}
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateContacto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$this->contacto->id ? 'Editar' : 'Agregar'}} Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Nombre</label>
                                <input wire:model.lazy="contacto.nombre" type="text" class="form-control" required />
                                @error('contacto.nombre')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label>Correo</label>
                                <input wire:model.lazy="contacto.correo" type="text" class="form-control" required />
                                @error('contacto.correo')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="form-group col-8">
                                <label>Departamento</label>
                                <input wire:model.lazy="contacto.departamento" type="text" class="form-control" required />
                                @error('contacto.departamento')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div class="form-group col-4">
                                <label>Prefijo</label>
                                <input wire:model.lazy="contacto.prefijo" type="text" class="form-control" required />
                                @error('contacto.prefijo')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
    
    
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button type="button" wire:click="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
    
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>

