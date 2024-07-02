<div>
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateWorkOrder">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Orden de Trabajo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label>Monto</label>
                            <input type="text" wire:model.defer="monto" class="form-control"
                                onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                style="width: 30%; text-align: right;">
                            @error('monto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">

                            @if ($this->entrada)
                                @if (!$this->haveEntrada)
                                    <button wire:click="$emit('initMdlSelectCliente')" class="btn btn-xs btn-success"><i
                                            class="fa fa-check"></i></button>
                                @endif

                                <label>Entrada: {{$this->entrada->folio_short}}</label>
                                <h5>{{ $this->entrada->vehiculo }}</h5>
                            @else
                                <button wire:click="$emit('initMdlSelectCliente')" class="btn btn-xs btn-secondary"><i
                                        class="fa fa-plus"></i></button>
                                <label>Seleccione Entrada</label>
                            @endif

                        </div>

                        <div class="form-group">



                            @if ($this->personal)
                                <button data-toggle="modal" data-target="#mdlSelectPersonal" class="btn btn-xs btn-success"><i
                                        class="fa fa-check"></i></button>
                                <label>Personal</label>
                                <h5>{{ $this->personal->nombre }}</h5>
                            @else
                                <button data-toggle="modal" data-target="#mdlSelectPersonal" class="btn btn-xs btn-secondary"><i
                                        class="fa fa-plus"></i></button>
                                <label>Seleccione Personal</label><br/>
                                @error('personal_id')
                                    <span class="text-danger">Seleccione Personal</span>
                                @enderror
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Notas</label>
                            <textarea type="text" wire:model.defer="notas" class="form-control"></textarea>
                            @error('notas')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-window-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" wire:click="crearOrden"><i class="fas fa-check"></i>
                        Crear</button>
                </div>


            </div>

        </div>
    </div>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectPersonal">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccione Personal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                    </div>

                    <table class="mt-2 table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Personal</th>
                                <th>Sueldo</th>
                                <th>Domicilio</th>
                                <th>Selecc.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalogo_personal as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>DESTAJO</td>
                                    <td>{{ $item->domicilio ? $item->domicilio : 'N/A' }}</td>
                                    <td><button wire:click="selectPersonal({{ $item->id }})"
                                            class="btn btn-xs btn-secondary"><i class="fa fa-check"></i> Seleccionar</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>

                    {{-- @if ($createMode)
                        <button type="button" class="btn btn-success" wire:click="createMaterial"><i
                                class="fas fa-save"></i>
                            Guardar</button>
                    @endif --}}
                </div>


            </div>

        </div>
    </div>


</div>
