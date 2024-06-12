<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlAsignarMaterial">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="form-group col-2">

                            @if (!$this->isTaller)
                                <label>Folio</label>
                                <input wire:model.defer="folioSearch" wire:keydown.enter="searchFolioHandler"
                                    style="text-transform: uppercase; text-align: center;" type="text"
                                    class="form-control" />
                                @error('model.numero_parte')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            @else
                                <label>Cantidad</label>
                                <input style="text-align: center;"
                                    wire:keydown.enter="asignarMaterial(null)"
                                    wire:model.defer="cantidadTaller" type="text"
                                    class="form-control form-control-sm"
                                    onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                            @endif

                            <div class="form-group mt-2">
                                <label for="isTaller">Asignar a Taller</label>
                                <input type="checkbox" id="isTaller" wire:model="isTaller" />
                            </div>

                        </div>

                        <div class="form-group col mt-1">
                            <h4>Material: {{ $this->selectedMaterial?->descripcion }}</h4>
                            @if ($this->selectedMaterial?->numero_parte)
                                <h4>Número de parte: {{ $this->selectedMaterial?->numero_parte }}</h4>
                            @endif
                            <h5>Existencia: {{ $this->selectedMaterial?->existencia }}</h5>
                        </div>
                    </div>

                    @if ($this->isTaller)
                        {{-- <div class="form-group">
                            <label>Folio</label>
                            <input wire:model.defer="folioSearch" wire:keydown.enter="searchFolioHandler"
                                style="text-transform: uppercase; text-align: center;" type="text"
                                class="form-control" />
                            @error('model.numero_parte')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror

                            <label>Asignar a Taller</label>
                            <input type="checkbox" wire:model="isTaller" />
                        </div> --}}
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Origen</th>
                                    <th>Cliente</th>
                                    <th>Vehículo</th>
                                    <th width="10%">Asignar</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->folios as $row)
                                    <tr>
                                        <td>{{ $row->folio_short }}</td>
                                        <td>{{ $row->origen }}</td>
                                        <td>{{ $row->cliente->nombre }}</td>
                                        <td>{{ $row->vehiculo }}</td>
                                        <td>
                                            <input style="text-align: center;"
                                                wire:keydown.enter="asignarMaterial({{ $loop->index }})"
                                                wire:model.defer="folios.{{ $loop->index }}.cantidad" type="text"
                                                class="form-control form-control-sm"
                                                onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                        </td>
                                        <td>
                                            <a target="_blank" href="servicios/{{ $row->id }}?activeTab=6"
                                                class="btn btn-xs btn-primary"><i class="fa fa-car"></i> Ver Entrada</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif




                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
