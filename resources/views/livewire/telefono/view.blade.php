<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlTelefonos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Teléfonos de {{ $morphsModel->nombre }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Extensión</th>
                            <th>Tipo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($telefonos as $key => $row)
                            <tr>
                                <td style="vertical-align: top;">
                                    <input  wire:model='telefonos.{{ $loop->index }}.numero'/>
                                    @error("telefonos.$loop->index.numero")
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="align-top">
                                    <input wire:model='telefonos.{{ $loop->index }}.extension' />
                                    @error("telefonos.$loop->index.extension")
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="align-top">
                                    <input wire:model='telefonos.{{ $loop->index }}.tipo' />
                                    @error("telefonos.$loop->index.tipo")
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button wire:click="removeTelefono({{ $loop->index }})"
                                        class='btn btn-danger btn-xs'>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between">
                    <button wire:click="addTelefono()" class="btn btn-xs btn-primary">
                        <i class="fas fa-plus"></i>Nuevo Teléfono
                    </button>

                </div>

                <br>

            </div>

            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('refreshComponent')" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>

                <button type="button" wire:click="save()" class="btn btn-success">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
