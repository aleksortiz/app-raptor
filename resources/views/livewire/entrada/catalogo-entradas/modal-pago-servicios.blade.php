<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPagoServicios">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$this->selectedEntrada?->folio_short}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover projects">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Concepto</th>
                            <th>($) Venta</th>
                            <th>Estatus Pago</th>
                            <th>No. Factura</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->selectedEntrada?->costos ?? [] as $item)
                            @php
                                $editMode = $this->selectedCosto && $this->selectedCosto->id == $item->id;
                                // $editMode = false;
                            @endphp
                            <tr>
                                <td>
                                    @if ($editMode)
                                        <button wire:click="saveCosto" class="btn btn-xs btn-success"><i
                                                class="fa fa-save"></i></button>
                                    @else
                                        {{-- <button wire:click="" onclick="destroy({{ $item->id }},'Costo', 'destroyCosto')" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button> --}}
                                    @endif
                                </td>

                                <td>
                                    @if ($editMode)
                                        <input wire:model="selectedCosto.concepto" type="text"
                                            class="form-control form-control-sm" />
                                        @error('selectedCosto.concepto')
                                            <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            @else
                                                {{ $item->concepto }}
                                    @endif
                                </td>
                                <td>
                                    @if ($editMode)
                                        <input wire:model="selectedCosto.costo" type="text"
                                            class="form-control form-control-sm"
                                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                        @error('selectedCosto.costo')
                                            <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            @else
                                                @money($item->costo)
                                    @endif
                                </td>
                                <td>
                                    @if ($item->pagado)
                                        @if ($editMode)

                                        <div class="row">
                                            <div class="col">
                                                <input style="display: inline-block;" wire:model="selectedCosto.pagado" type="datetime-local"
                                                class="form-control form-control-sm" />
                                                @error('selectedCosto.pagado')
                                                    <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            </div>
                                            <div class="col-2">
                                                <button style="display: inline-block;" wire:click="eliminarPagoServicio({{ $item->id }})" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>

                                        
                                            
                                        @else
                                            <i style="color: green;" class="fa fa-check"></i> Pagado:
                                            {{ $item->fecha_pago_format }}
                                        @endif
                                    @else
                                        @if ($editMode)
                                            N/A
                                        @else
                                            <button wire:click="pagarServicio({{ $item->id }})"
                                                class="btn btn-xs btn-secondary"><i class="fa fa-clock"></i> Pago
                                                Pendiente</button>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($editMode)
                                        <input wire:model="selectedCosto.no_factura" type="text"
                                            class="form-control form-control-sm" />
                                        @error('selectedCosto.no_factura')
                                            <span class="error text-danger">{{ $message }}<span>
                                        @enderror
                                    @else
                                        {{$item->no_factura ? $item->no_factura : 'N/A'}}
                                    @endif
                                </td>
                                <td>
                                    @if ($editMode)
                                        <button wire:click="removeCosto" class="btn btn-danger btn-xs"><i
                                                class="fa fa-times"></i> Cancelar</button>
                                    @else
                                        <button wire:click="editCosto({{ $item->id }})"
                                            class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
