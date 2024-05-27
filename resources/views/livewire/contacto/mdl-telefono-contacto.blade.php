<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlTelefonos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$this->contacto->prefijo_nombre}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <button wire:click="addRow" class="btn btn-xs btn-success m-2"><i class="fa fa-plus"></i> Agregar Num.</button>
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número</th>
                            <th>Tipo</th>
                            <th>Ext.</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($this->telefonos as $tel)
                        @if(isset($this->selectedTelefono->id) && ($this->selectedTelefono->id == $tel->id) || (!$tel->id))
                            <tr>
                                <td><button wire:click="cancelEdit" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                                <td>
                                    <input wire:model="selectedTelefono.numero" class="form-contol" />
                                    @error('selectedTelefono.numero')
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>

                                <td>
                                    <select wire:model="selectedTelefono.tipo" class="form-control">
                                        <option value="CELULAR">CELULAR</option>
                                        <option value="OFICINA">OFICINA</option>
                                        <option value="CASA">CASA</option>
                                    </select>
                                    @error('selectedTelefono.tipo')
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input wire:model="selectedTelefono.extension" class="form-contol" />
                                    @error('selectedTelefono.extension')
                                        <div class="error text-danger text-sm">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button wire:click="save" class="btn btn-xs btn-primary"><i class="fa fa-save"></i></button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$tel->numero}}</td>
                                <td>{{$tel->tipo}}</td>
                                <td>{{$tel->ext_format}}</td>
                                <td>
                                    <button wire:click="edit({{$tel->id}})" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                    <button onclick="destroy({{$tel->id}}, 'Teléfono: {{$tel->numero}}', 'destroyTelefono')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
