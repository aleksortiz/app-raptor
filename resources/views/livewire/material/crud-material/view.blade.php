@section('title', __($this->model_name_plural))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catalogo de {{ $this->model_name_plural }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            
            <div class="row m-2">
                <div class="col-9">
                    <div class="form-group">
                        <label for="keyWord">Buscar material</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="gotoFolio">Ir a folio:</label>
                        <input type="text" wire:model.defer="gotoFolio" wire:keydown.enter="redirectFolio" class="form-control" id="gotoFolio" placeholder="Folio">
                    </div>
                </div>
            </div>

            
            
            @canany(['administrar-materiales'])
            <button class="btn btn-xs btn-primary ml-2 mb-2" wire:click="mdlCreate"><i class="fas fa-plus"></i> Agregar
              {{ $this->model_name }}</button>
            @endcanany

            <button class="btn btn-xs btn-success mb-2" wire:click="exportToExcel"><i class="fas fa-file-excel"></i> Exportar a Excel</button>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número de Parte</th>
                        <th>Categoria</th>
                        <th>Descripción</th>
                        <th>Unidad de Medida</th>
                        <th>Precio</th>
                        <th>Existencia</th>
                        <th>Asignar</th>
                        @canany(['administrar-materiales'])
                        <th>Opciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->numero_parte ? $row->numero_parte : "N/A" }}</td>
                            <td>{{ $row->categoria }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>{{ $row->unidad_medida }}</td>
                            <td>@money($row->precio)</td>
                            <td>{{ $row->existencia }}</td>
                            <td>
                                <button class="btn btn-xs btn-primary" wire:click="mdlAsignarMaterial({{ $row->id }})"><i class="fa fa-car"></i> Asignar a folio</button>
                            </td>

                            @canany(['administrar-materiales'])
                                <td>
                                    <button class="btn btn-xs btn-warning" wire:click="mdlEdit({{ $row->id }})"><i
                                            class="fa fa-edit"></i> Editar</button>
                                    {{-- <button class="btn btn-xs btn-danger" wire:click="mdlDelete({{ $row->id }})"><i
                                            class="fas fa-trash"></i> Eliminar</button> --}}
                                </td>
                            @endcanany

                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $data->links() }}

    @include('livewire.material.crud-material.modal')
    @include('livewire.material.crud-material.modal-asignar-material')

</div>
