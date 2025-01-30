
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
                        <input type="text" wire:model.lazy="search" class="form-control" id="search" placeholder="Buscar...">
                    </div>
                </div>

            </div>

            <div class="p-2">
                <button wire:click="$emit('showModal','#mdlCrearRefaccion')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registrar Refacción</button>
            </div>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Reporte</th>
                        <th>No. Parte</th>
                        <th>Descripción</th>
                        <th>Proveedor</th>
                        <th>Condición</th>
                        <th>Recepción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($refacciones ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->no_reporte_format }}</td>
                            <td>{{ $item->no_parte }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->nombre_proveedor }}</td>
                            <td>{{ $item->condicion }}</td>
                            <td>{{ $item->fecha_recepcion_format }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $refacciones->links() }}

</div>

