<div class="d-inline">
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdlSelectProyect">
        <i class="fa fa-file-invoice-dollar"></i> Solicitudes de Compra
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectProyect">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccione Solicitudes de compra:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Selecc.</th>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Requisitor</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($solicitudes as $item)
                                    <tr>
                                        <td>
                                            <label class="content-input">
                                                <input wire:model="selectedSolicitudes.{{$item->id}}.selected" type="checkbox" />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>{{$item->id_paddy}}</td>
                                        <td>{{$item->fecha_creacion}}</td>
                                        <td>{{$item->user->name}}</td>
                                        <td><livewire:compra.common.btn-detalles :solicitud="$item" :wire:key="$item->id" /> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{-- {{$proyectos->links()}} --}}
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                    @php
                        $selected = collect($this->selectedSolicitudes)->filter(function($value, $key){
                            return $value['selected'] == true;
                        });
                        $sumSelected = $selected->count();
                    @endphp
                    @if ($sumSelected > 0)
                        <button type="button" wire:click="$emitUp('setSolicitudes',{{ json_encode($selected) }})" data-dismiss="modal" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check"></i> Aceptar</button>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
