<div class="d-inline">
    <button class="btn btn-xs {{$btn_color}}" data-toggle="modal" data-target="#{{$this->modalName}}">
        <i class='fa {{$btn_icon}}'></i> ({{$this->telefonos->count()}})
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->modalName}}">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$this->contacto->prefijo_nombre}}</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#{{$this->modalName}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">                
                    @can($this->adminCan)
                        <button wire:click="addRow" class="btn btn-xs btn-success m-2"><i class="fa fa-plus"></i> Agregar Num.</button>
                    @endcan
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Ext.</th>
                                @can($this->adminCan)
                                <th>Opciones</th>
                                @endcan
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
                                    @can($this->adminCan)
                                    <td>
                                        <button wire:click="save" class="btn btn-xs btn-primary"><i class="fa fa-save"></i></button>
                                    </td>
                                    @endcan
                                </tr>
                            @else
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$tel->numero}}</td>
                                    <td>{{$tel->tipo}}</td>
                                    <td>{{$tel->ext_format}}</td>
                                    @can($this->adminCan)
                                    <td>
                                        <button wire:click="edit({{$tel->id}})" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                        <button onclick="destroy({{$tel->id}}, 'Teléfono: {{$tel->numero}}', 'deletePhone{{$this->contacto->id}}')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                    </td>
                                    @endcan
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button data-toggle="modal" data-target="#{{$this->modalName}}" type="button" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
