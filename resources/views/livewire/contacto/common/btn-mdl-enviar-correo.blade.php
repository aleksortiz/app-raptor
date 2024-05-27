<div class="d-inline">

    <button data-toggle="modal" data-target="#mdlEnviarCorreo{{$this->model->id}}" class="btn btn-xs btn-warning" ><i class="fa fa-envelope"></i> Enviar</button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEnviarCorreo{{$this->model->id}}">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$cardTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Asunto</label>
                                <input type="text" wire:model="asuntoCorreo" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Mensaje</label>
                                <textarea rows="6" wire:model="mensajeCorreo" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Departamento</th>
                                        <th>Enviar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contactos as $item)
                                    <tr>
                                        <td>{{$item->nombre}}</td>
                                        <td>{{$item->correo}}</td>
                                        <td>{{$item->departamento}}</td>
                                        <td>
                                            <label class="content-input">
                                                <input wire:model.lazy="selectedContactos.{{$item->id}}.send" type="checkbox"/>
                                                <i></i>
                                            </label>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
    
    
    
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-toggle="modal" data-target="#mdlEnviarCorreo{{$this->model->id}}" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cancelar</button>
                    <div wire:loading.remove wire:target="enviarCorreo">
                        @php
                            $btn = collect($this->selectedContactos)->filter(function($item){
                                return $item['send'];
                            })->count() > 0;
                        @endphp
                        @if($btn)
                            <button type="button" wire:click="enviarCorreo" class="btn btn-success"><i class="fas fa-paper-plane"></i> Enviar</button>
                        @endif
                    </div>
                    <div wire:loading wire:target="enviarCorreo">
                        <button disabled type="button" class="btn btn-success"><i class="fas fa-spin fa-spinner"></i> Enviando</button>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
</div>

