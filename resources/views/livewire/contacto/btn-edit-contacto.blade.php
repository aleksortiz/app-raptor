<div>
    <button wire:click="mdl(0)" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> {{$this->contacto->nombre}} Editar</button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlBtnEdit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Contactco</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Nombre</label>
                                <input wire:contacto.lazy="contacto.nombre" type="text" class="form-control" required />
                                @error('contacto.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-6">
                                <label>Correo</label>
                                <input wire:contacto.lazy="contacto.correo" type="text" class="form-control" required />
                                @error('contacto.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="form-group col-8">
                                <label>Departamento</label>
                                <input wire:contacto.lazy="contacto.departamento" type="text" class="form-control" required />
                                @error('contacto.departamento') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
    
                            <div class="form-group col-4">
                                <label>Prefijo</label>
                                <input wire:contacto.lazy="contacto.prefijo" type="text" class="form-control" required />
                                @error('contacto.prefijo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>                        
                        </div>
    
    
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                    @if (true)
                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    @else
                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
