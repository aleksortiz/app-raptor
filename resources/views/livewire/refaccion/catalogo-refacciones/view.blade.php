<div class="pt-3">
    
    @livewire('refaccion.mdl-crear-refaccion')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Refacciones</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            
            <div class="row p-3">
                <div class="col">
                    <div class="form-group">
                        <label for="search">Buscar</label>
                        <input type="text" wire:model.lazy="search" class="form-control" id="search" placeholder="Buscar por descripción o número de parte...">
                    </div>
                </div>
            </div>

            <div class="p-2">
                <button wire:click="$emit('showModal','#mdlCrearRefaccion')" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nueva Refacción
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 70px">#</th>
                            <th>No. Parte</th>
                            <th>Descripción</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Condición</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refacciones ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->no_parte }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->nombre_proveedor }}</td>
                                <td>
                                    <span class="badge {{ $item->estado === 'PENDIENTE' ? 'badge-warning' : 'badge-success' }}">
                                        {{ $item->estado }}
                                    </span>
                                </td>
                                <td>{{ $item->condicion }}</td>
                                <td>
                                    <a href="/refacciones/ver-refaccion/{{ $item->id }}" class="btn btn-xs btn-warning">
                                        <i class="fas fa-cogs"></i> Ver Refacción
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="px-3">
        {{ $refacciones->links() }}
    </div>

    <!-- Modal para Ver Refacción -->
    @if($showingRefaccion && $selectedRefaccion)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de la Refacción</h5>
                    <button type="button" class="close" wire:click="closeRefaccion">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    @livewire('refaccion.ver-refaccion', ['refaccion' => $selectedRefaccion], key('refaccion-'.$selectedRefaccion->id))
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeRefaccion">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

