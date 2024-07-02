<div>
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCatalogoMateriales">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccione Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    @if ($this->createMode)
                        <div>
                            {{-- <button wire:click="$set('createMode', false)" class="btn btn-secondary btn-xs mb-3"><i
                                    class="fa fa-arrow-left"></i> Regresar</button> --}}
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Número de Parte</label>
                                    <input wire:model.defer="material.numero_parte" style="text-transform: uppercase;"
                                        type="text" class="form-control" required />
                                    @error('material.numero_parte')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-8">
                                    <label>Categoria</label>
                                    <input wire:model.defer="material.categoria" style="text-transform: uppercase;"
                                        type="text" class="form-control" required />
                                    @error('material.categoria')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-9">
                                    <label>Descripción</label>
                                    <input wire:model.defer="material.descripcion" type="text" class="form-control"
                                        required />
                                    @error('material.descripcion')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-3">
                                    <label>Unidad de Medida</label>
                                    <input wire:model.defer="material.unidad_medida" type="text" class="form-control"
                                        style="text-align: center; text-transform: uppercase;" />
                                    @error('material.unidad_medida')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-3">
                                    <label>Precio</label>
                                    <input wire:model.defer="material.precio" type="text" class="form-control"
                                        style="text-align: right;" />
                                    @error('material.precio')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-3">
                                    <label>Existencia</label>
                                    <input wire:model.defer="material.existencia" type="text" class="form-control"
                                        style="text-align: center" />
                                    @error('material.existencia')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>Comentarios</label>
                                    <textarea class="form-control" wire:model.defer="material.comentarios"></textarea>
                                    @error('material.comentarios')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="form-group">
                                <label>Buscar</label>
                                <input type="text" wire:model.lazy="keyWord" class="form-control"
                                    placeholder="Busqueda">
                            </div>

                            {{-- <button wire:click="$set('createMode', true)" class="btn btn-primary btn-xs"><i
                                    class="fa fa-plus"></i> Nuevo Material</button> --}}
                            <table class="mt-2 table">
                                <thead>
                                    <tr>
                                        <th>Número de Parte</th>
                                        <th>Categoria</th>
                                        <th>Material</th>
                                        <th>Unidad de Medida</th>
                                        <th>Precio</th>
                                        <th>Existencia</th>
                                        <th>Selecc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materiales as $item)
                                        <tr>
                                            <td>{{ $item->numero_parte }}</td>
                                            <td>{{ $item->categoria }}</td>
                                            <td>{{ $item->descripcion }}</td>
                                            <td>{{ $item->unidad_medida }}</td>
                                            <td>@money($item->precio)</td>
                                            <td>{{ $item->existencia }}</td>
                                            <td>
                                                <button wire:click="mdlQty({{ $item->id }})"
                                                    class="btn btn-xs btn-secondary"><i class="fa fa-check"></i>
                                                    Seleccionar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                        data-target="#mdlCatalogoMateriales"><i class="fas fa-window-close"></i> Cerrar</button>

                        @if ($createMode)
                            <button type="button" class="btn btn-success" wire:click="createMaterial"><i class="fas fa-save"></i>
                                Guardar</button>
                        @endif
                </div>


            </div>

        </div>
    </div>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCantidadMaterial">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingrese Cantidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <center>
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="text" wire:model.debounce.1s="cantidad" class="form-control form-control-lg"
                                onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                style="text-align: center; width: 50%">
                            @error('cantidad')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Material</label>
                                <p>{{ $this->selectedMaterial?->descripcion }}</p>
                            </div>
                            <div class="col">
                                <label>Existencia</label>
                                <p>{{ $this->selectedMaterial?->existencia }}</p>
                            </div>
                            <div class="col">
                                <label>Importe</label>
                                <p>@money($this->qty * $this->selectedMaterial?->precio)</p>
                            </div>
                        </div>
                    </center>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-window-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" wire:click="setMaterial"><i
                            class="fas fa-check"></i>
                        Aceptar</button>
                </div>


            </div>

        </div>
    </div>
</div>
