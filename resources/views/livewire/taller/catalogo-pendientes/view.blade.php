
<div class="pt-3">
    
    @livewire('refaccion.mdl-crear-refaccion')

    @include('livewire.taller.catalogo-pendientes.modal')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tareas del Taller</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row p-3">
                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Año</label>
                        <select wire:model.lazy="year" class="form-control" id="year">
                            @foreach (range(Date('Y'), 2024) as $item)
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
                            @foreach (range($this->weekStart, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-2">
                    <div class="form-group">
                        <label for="user_id_search">Responsable:</label>
                        <select wire:model.lazy="user_id_search" class="form-control" id="user_id_search">
                            <option value="">Todos</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-2 pt-3">
                    <div class="pt-4">
                        <button wire:click="$emit('showModal','#mdlCrearPendiente')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registrar Pendiente</button>
                    </div>
                </div>


                <div class="col-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pendientes totales: {{$this->pendientes_count}}</b></span>
                        </div>
                    </div>
                </div>

                <div class="col-2">

                    <div class="form-group">
                        <label for="keyWord">Solo pendientes:</label>
                        <label class="content-input">
                            <input  type="checkbox" wire:model="solo_pendientes" />
                            <i></i>
                        </label>
                    </div>
                </div>

            </div>




            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Registrado</th>
                        <th>Responsable</th>
                        <th>Tarea a Realizar:</th>
                        <th>Fecha Promesa</th>
                        <th>Concluido</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendientes as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('d/M/Y h:i A') }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->fecha_promesa_format }}</td>
                            <td>
                                @if($item->user_id == auth()->user()->id && !$item->fecha_terminado)
                                    <label class="content-input">
                                        {{-- <input  type="checkbox" wire:click="check({{$item->id}})" /> --}}
                                        <input  type="checkbox" onclick="confirm('Marcar tarea como concluida', 'check', {{$item->id}})" />
                                        <i></i>
                                    </label>
                                @else
                                    @if (!$item->fecha_terminado)
                                        <button class="btn btn-warning btn-xs"><i class="fa fa-clock"></i> PENDIENTE</button>
                                    @else
                                        <button class="btn btn-success btn-xs"><i class="fa fa-check"></i> {{$item->fecha_terminado_format}}</button>
                                    @endif
                                @endif


                                {{-- @if($item->user_id == auth()->user()->id)
                                    {!! 
                                        $item->fecha_terminado ? $this->fecha_terminado :
                                        '<label class="content-input">
                                            <input  '. ($item->fecha_terminado ? 'checked' : '') .' type="checkbox" wire:click="check(' . $item->id . ')" />
                                            <i></i>
                                        </label>';
                                    !!}
                                @else
                                    {!! 
                                        $item->fecha_terminado ? $this->fecha_terminado :
                                        '<button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> PENDIENTE</button>';
                                    !!}
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $pendientes->links() }}

</div>

