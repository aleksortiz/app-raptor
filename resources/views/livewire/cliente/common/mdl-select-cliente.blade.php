<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccione Cliente:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($this->createMode)
                    <div class="m-2">
                        <button wire:click="$set('createMode', false)" class="btn btn-xs btn-secondary"><i class="fa fa-arrow-left"></i> Regresar</button>
                    </div>
                    <div>

                        <div class="row">
                            <div class="form-group col-8">
                                <label>Nombre</label>
                                <input wire:model.defer="cliente.nombre" type="text" class="form-control" required />
                                @error('cliente.nombre')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label>Teléfono</label>
                                <input wire:model.defer="cliente.telefono" maxlength="15" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                    class="form-control" required />
                                @error('cliente.telefono')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>RFC</label>
                                <input wire:model.defer="cliente.rfc" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.rfc')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-8">
                                <label>Razón Social</label>
                                <input wire:model.defer="cliente.razon_social" type="text" class="form-control" required />
                                @error('cliente.razon_social')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-5">
                                <label>Calle</label>
                                <input wire:model.defer="cliente.calle" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.calle')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label>Número</label>
                                <input wire:model.defer="cliente.numero" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.numero')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-5">
                                <label>Colonia</label>
                                <input wire:model.defer="cliente.colonia" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.colonia')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-2">
                                <label>Código Postal</label>
                                <input wire:model.defer="cliente.codigo_postal" style="text-transform: uppercase;"
                                    type="text" class="form-control" required />
                                @error('cliente.codigo_postal')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-5">
                                <label>Ciudad</label>
                                <input wire:model.defer="cliente.ciudad" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.ciudad')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-5">
                                <label>Estado</label>
                                <input wire:model.defer="cliente.estado" style="text-transform: uppercase;" type="text"
                                    class="form-control" required />
                                @error('cliente.estado')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                @else
                    <div class="form-group m-3">
                        <label for="keyWord">Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                    </div>
                    <div class="m-2">
                        <button wire:click="$set('createMode', true)" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Crear Cliente</button>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $item)
                            <tr>
                                <td>{{$item->id_paddy}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->direccion}}</td>
                                <td><button wire:click="select({{$item->id}})" class="btn btn-xs btn-secondary"><i class="fa fa-check"></i> Seleccionar</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->createMode)
                    <button type="button" wire:click="create" class="btn btn-success"><i class="fas fa-check"></i> Crear Cliente</button>
                @else
                    {{$clientes->links()}}
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>





