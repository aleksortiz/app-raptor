<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlRegistrarPagoDestajo">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Monto: @money($this->selectedWorkOrder?->monto)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col">
                        @if ($this->selectedWorkOrder?->pendiente <= 0)
                        <center>
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i> Trabajo Pagado
                            </div>
                        </center>
                            
                        @else                            
                            <div class="form-group">
                                <label for="">Registrar Pago</label>
                                <input type="text" wire:model.defer="pagoDestajo" wire:keydown.enter="registrarPagoDestajo" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="width: 30%; text-align: right;" class="form-control">
                                @error('pagoDestajo') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        @endif
                    </div>
                </div>

                
                <div class="row">

                    <div class="col">
                        <div class="form-group">
                            <label for="">Personal</label>
                            <p>{{$this->selectedWorkOrder?->personal->nombre ?? ''}}</p>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="">Pagado</label>
                            <p>@money($this->selectedWorkOrder?->pagado)</p>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="">Pendiente de Pago</label>
                            <p>@money($this->selectedWorkOrder?->pendiente)</p>
                        </div>
                    </div>
                </div>



                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->selectedWorkOrder?->pagos ?? [] as $item)
                        <tr>
                            <td><button onclick="confirm('Eliminar Pago', 'removeOrdenPago', {{$item->id}})" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>@money($item->monto)</td>
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
