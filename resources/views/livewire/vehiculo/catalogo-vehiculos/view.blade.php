
<div class="pt-3">
    
    @include('livewire.vehiculo.catalogo-vehiculos.modal')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehículos</h3>
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
                <button wire:click="$emit('showModal','#mdl')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registrar Vehículo</button>
            </div>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehículo</th>
                        <th>Serie</th>
                        <th>Placas</th>
                        <th>Factura</th>
                        <th>Pedimento</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehiculos ?? [] as $item)
                        <tr style="cursor: pointer" onclick="window.location.href='/vehiculos/{{$item->id}}'; return false;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->serie }}</td>
                            <td>{{ $item->placa }}</td>
                            <td>{{ $item->factura }}</td>
                            <td>{{ $item->pedimento }}</td>
                            <td>{{ $item->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    {{ $vehiculos->links() }}

</div>

