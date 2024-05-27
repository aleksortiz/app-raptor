<div class="d-inline">
    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#btnDtl{{$this->solicitud->id}}">
        <i class='fa fa-info'></i> Detalles
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="btnDtl{{$this->solicitud->id}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proyecto: #{{$this->solicitud->proyecto->id_paddy}}, Solicitud de Compra: #{{$this->solicitud->id_paddy}}</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#btnDtl{{$this->solicitud->id}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-3 mt-3">
                            <h5>Folio: {{$this->solicitud->id_paddy}}</h5>
                            <hr>
                            <h5>Fecha: {{$this->solicitud->fecha_creacion}}</h5>
                            <hr>
                            <h5>Requisitor: {{$this->solicitud->user->name}}</h5>
                            <hr>
                            <button class='btn {{$this->solicitud->estatus_color}}'>{{$this->solicitud->estatus}}</button>
                            <br>
                            <br>

                            @if ($this->solicitud->estatus == 'AUTORIZADO')
                                <label class="m-0">Autorizado por: {{$this->solicitud->autorizado_por->name}}</label><br>
                                <p>Fecha: {{$this->solicitud->fecha_autorizacion}}</p>
                                <p>{{$this->solicitud->comentarios_autorizacion}}</p>
                            @endif
                            @if ($this->solicitud->estatus == 'RECHAZADO')
                                <label class="m-0">Rechazado por: {{$this->solicitud->rechazado_por}}</label><br>
                                <p>Fecha: {{$this->solicitud->fecha_rechazo}}</p>
                                <p>{{$this->solicitud->motivos_rechazo}}</p>
                            @endif

                            @if ($this->solicitud->estatus == 'PENDIENTE AUTORIZAR' && auth()->user()->can('autorizar-solicitud-compra'))
                                <div class="row">
                                    <div class="col">
                                        <label>Autorizar</label>
                                        <label class="content-input">
                                            <input wire:model="autorizar" type="checkbox" />
                                            <i></i>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label>Rechazar</label>
                                        <label class="content-input red">
                                            <input wire:model="rechazar" type="checkbox" />
                                            <i></i>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <br>
                                        @if ($this->autorizar)
                                            <button wire:click="autorizar" class='btn btn-success btn-xs'><i class="fa fa-check"></i><br>AUTORIZAR</button>
                                        @endif
                                        @if ($this->rechazar)
                                            <button wire:click="rechazar" class='btn btn-danger btn-xs'><i class="fa fa-times"></i><br>RECHAZAR</button>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    @if ($this->autorizar || $this->rechazar)                                    
                                        <label>{{$this->autorizar ? 'Comentarios' : 'Motivos'}}</label>
                                        <textarea wire:model="comentarios" class="form-control"></textarea>
                                        @error('comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                            @endif

                        </div>
                        <div class="col">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Número de Parte</th>
                                        <th>Descripción</th>
                                        <th>Unidad de Venta</th>
                                        <th>Cantidad Solicitada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($this->solicitud->conceptos as $item)
                                    <tr>
                                        <td>{{$item->numero_parte}}</td>
                                        <td>{{$item->descripcion}}</td>
                                        <td>PZ</td>
                                        <td align="center">{{$item->cantidad_solicitada}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#btnDtl{{$this->solicitud->id}}"><i class="fas fa-window-close"></i> Cerrar</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
