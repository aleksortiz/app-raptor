
<div class="pt-3">
    
    @livewire('refaccion.mdl-crear-refaccion')

    @include('livewire.taller.catalogo-pendientes.modal')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pendientes del Taller</h3>
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
                        <select wire:model="year" class="form-control" id="year">
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
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-3">
                    <div class="form-group">
                        <label for="user_id">Responsable:</label>
                        <select wire:model.lazy="user_id" class="form-control" id="user_id">
                            <option value="">Todos</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-4 pt-3">
                    <div class="pt-4">
                        <button wire:click="$emit('showModal','#mdlCrearPendiente')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registrar Pendiente</button>
                    </div>
                </div>

            </div>




            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Responsable</th>
                        <th>Descripción</th>
                        <th>Fecha Promesa</th>
                        <th>Concluido</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendientes ?? [] as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->fecha_promesa_format }}</td>
                            <td>
                                @if($item->user_id == auth()->user()->id)
                                    {!! 
                                        $item->fecha_terminado_format ? $this->fecha_terminado_format :
                                        '<label class="content-input">
                                            <input '. ($item->fecha_terminado ? 'checked' : '') .' type="checkbox" />
                                            <i></i>
                                        </label>'
                                    !!}
                                @else
                                    {!! 
                                        $item->fecha_terminado_format ? $this->fecha_terminado_format :
                                        'PENDIENTE'
                                    !!}
                                @endif
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

