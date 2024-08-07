@section('title', __('Pedidos'))
<div class="pt-3">
    <div style="min-height: 85vh" class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $this->model_name_plural }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row">
                <div class="col">
                    <center>
                        <div wire:loading>
                            <div class="pt-5" style="background: white">
                                <img src="{{ asset('images/logo.png') }}" height="150px;">
                                <h1><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                            </div>
                        </div>
                    </center>
                </div>
            </div>

            <div wire:loading.remove>

                <div class="row pl-3 pt-3">

                    <div class="col-1">
                        <div class="form-group">
                            <label for="keyWord">Año</label>
                            <select wire:model.lazy="year" class="form-control" id="year">
                                @foreach (range(2021, $this->maxYear) as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <div class="col-1">
                        <div class="form-group">
                            <label for="keyWord">Semana</label>
                            <select wire:model.lazy="weekStart" class="form-control" id="weekStart">
                                @foreach (range(1, 52) as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
    
                    <div class="col-1">
                        <div class="form-group">
                            <label for="keyWord">a la</label>
                            <select wire:model.lazy="weekEnd" class="form-control" id="weekEnd">
                                @foreach (range(1, 52) as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
    
                    <div class="col-2">
                        <div class="mt-4">
                            <a href="/materiales/crear-pedido" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Crear Pedido</a>
                        </div>
                    </div>
    
                </div>
    
                <div class="row">
    
                    <div class="col-sm-3">
                        <div class="info-box" wire:click="selectProvider(null)" style="cursor: pointer;">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck"></i></span>
        
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Total Pedidos</b></span>
                                <span class="info-box-number">@money($totalProveedores)</span>
                            </div>
        
                        </div>
                    </div>
    
                    @foreach ($proveedores as $item)
                        <div class="col-sm-3">
                            <div class="info-box" wire:click="selectProvider({{$item->id}})" style="cursor: pointer;">
                                <span class="info-box-icon @if($item->id == $this->providerId) bg-primary @else bg-default @endif elevation-1"><i
                                        class="fas fa-truck"></i></span>
    
                                <div class="info-box-content">
                                    <span class="info-box-text"><b>{{$item->nombre}}</b></span>
                                    <span class="info-box-number">@money($this->totalProvider($item->id))</span>
                                </div>
    
                            </div>
                        </div>
                    @endforeach
    
    
                </div>
    
                <table class="mt-3 table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Proveedor</th>
                            <th>Importe</th>
                            <th>Estatus</th>
                            <th>Est. Pago</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->id_paddy }}</td>
                                <td>{{ $row->fecha_creacion }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->proveedor->nombre }}</td>
                                <td>@money($row->total)</td>
                                <td>{{ $row->estatus_recibido }}</td>
                                <td>{!! $row->estatus_pago_button !!}</td>
                                <td>
                                    <div>
                                        <button type="button" class="btn btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> Opciones</button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item"><b>Pedido: #{{$row->id_paddy}}</b></a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="cursor: pointer;" wire:click="mdlEnviarCorreo({{ $row->id }})"><i class="fas fa-envelope"></i> Enviar Pedido</a>
                                            <a class="dropdown-item" href='/materiales/pedido_pdf/{{ $row->id }}' target="_blank"><i class="fas fa-file-alt"></i> Ver Pedido</a>
                                            <a class="dropdown-item" style="cursor: pointer;" wire:click="$emit('initMdlRecibirPedido',{{ $row }})"><i class="fas fa-truck"></i> Recibir Pedido</a>
                                            @role('gerente')
                                                <a class="dropdown-item" style="cursor: pointer;" wire:click="mdlProviders({{$row->id}})"><i class="fa fa-exchange-alt"></i> Cambiar Proveedor</a>
                                            @endrole
                                        </div>
                                    </div>
                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $data->links() }}

        
            </div>



        </div>
    </div>

    @include('livewire.pedido.catalogo-pedidos.modal-edit-date')
    @include('livewire.pedido.catalogo-pedidos.modal-change-provider')
</div>
