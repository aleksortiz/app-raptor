@section('title', __('Ticket de Soporte'))
<div class="pt-3">

    <div class="row">
        <div class="col">
            <div class="card" style="">
                <div class="card-header">
                    <h3 class="card-title">Ticket de Soporte</h3>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-4">
                            <div class="p-3">
                                <h3>Folio #{{$this->ticket->id_paddy}}</h3>
                                <h5>Fecha: {{$this->ticket->fecha_creacion}}</h5>
                                <h5>Usuario: {{$this->ticket->user_name}}</h5>
                                <h5>Tipo: {{$this->ticket->type}}</h5>
                                <h5 style="display: inline" class="pr-2">Estatus:</h5>
                                <button style="display: inline" class="btn btn-{{$this->ticket->status_color}} btn-xs">{{$this->ticket->status}}</button>
                                @if($this->ticket->cost)
                                <h5>Costo: @money($this->ticket->cost)</h5>
                                @endif

                                <br>
                                <br>

                                @if ($this->ticket->status == 'ESPERANDO VALIDACION')                   
                                <h5 style="display: inline" class="pr-2">Validar:</h5>
                                <button onclick="confirm('Cerrar ticket', 'validar')" style="display: inline" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Validar y cerrar</button>
                                @endif



                            </div>
                        </div>
                        <div class="col-8">
                            <div class="p-3">
                                <textarea rows="6" class="form-control" readonly>{{$this->ticket->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="card" style="min-height: 85vh;">
                <div class="card-header">
                    <h3 class="card-title">Historial de estatus</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover projects">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket->logs as $log)
                            <tr>
                                <td>{{$log->fecha_creacion}}</td>
                                <td><button class="btn btn-xs btn-{{$log->status_color}}">{{$log->status}}</button></td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="min-height: 85vh;">
                <div class="card-header">
                    <h3 class="card-title">Comentarios</h3>
                    <div class="card-tools">
                        <button type="button" wire:click="mdlCreateComment" class="btn btn-xs btn-primary" >
                            <i class="fas fa-comments"></i> Agregar Comentario
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover projects">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket->comments as $comment)
                            <tr>
                                <td>{{$comment->fecha_creacion}}</td>
                                <td>{{$comment->user_name}}</td>
                                <td>{{$comment->comment}}</td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.aoscore.view-support-ticket.mdlComentario')
</div>
