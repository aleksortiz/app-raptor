<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Monto Prestamo: @money($this->prestamo?->monto)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">

                <div class="row m-3">
                    <div class="col">   
                        <h5><b>Fecha Creación:</b> {{ $this->prestamo?->fecha_creacion }}</h5>
                        <h5><b>Coutas Pendientes:</b> {{ $this->prestamo?->cuotas_pendientes }} / {{ $this->prestamo?->cuotas }}</h5>
                    </div>

                    <div class="col">
                        <h5><b>Pagado:</b> @money($this->prestamo?->pagado)</h5>
                        <h5><b>Saldo Pendiente:</b> @money($this->prestamo?->saldo_pendiente)</h5>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cuota</th>
                            <th>Fecha</th>
                            <th>Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->prestamo?->pagos ?? [] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>@money($item->monto)</td>
                                <td>{{ $item->fecha }}</td>
                                <td>
                                    @if ($item->pagado)
                                        <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Pagado</button>
                                    @else
                                        <button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> Pendiente</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                {{-- <button type="button" class="btn btn-primary" wire:click="save"><i class="fas fa-save"></i> Guardar Datos</button> --}}
            </div>
        </div>
    </div>
</div>
