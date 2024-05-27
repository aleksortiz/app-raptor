<div class="d-inline">
    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#mdlSelectContacts{{$this->model->id}}">
        <i class='fa fa-users'></i> Seleccionar Contactos
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectContacts{{$this->model->id}}">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Contactos</h5>
                    <button type="button" class="close" data-target="#mdlSelectContacts" data-toggle="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Buscar</label>
                        <input type="text" wire:model.lazy="searchValueContactos" class="form-control" placeholder="Busqueda">
                    </div>
    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Departamento</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactos as $contacto)
                            <tr>
                                <td>{{$contacto->nombre}}</td>
                                <td>{{$contacto->correo}}</td>
                                <td>{{$contacto->departamento}}</td>
                                <td>
                                    <label class="content-input">
                                        <input wire:model.lazy="selectedContactos.{{$contacto->id}}.selected" type="checkbox"/>
                                        <i></i>
                                    </label>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-target="#mdlSelectContacts{{$this->model->id}}" data-toggle="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
                    <button type="button" data-target="#mdlSelectContacts{{$this->model->id}}" data-toggle="modal" wire:click="saveContactos()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Contactos</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
