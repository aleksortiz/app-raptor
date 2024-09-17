<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">

{{--
        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total Sueldos:</b></span>
                      <span class="info-box-number">@money($this->entrada->pagos_personal->sum('pago'))</span>
                    </div>

                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col">
                {{-- <button class="btn btn-primary btn-xs m-2" wire:click="mdlCreateWorkOrder"><i class="fa fa-plus"></i> Crear Orden Trabajo</button> --}}
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha Creación</th>
                            <th>Personal</th>
                            <th>Monto</th>
                            <th>Pagado</th>
                            <th>Notas</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->ordenes_trabajo as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->personal->nombre}}</td>
                            <td>@money($item->monto)</td>
                            <td>@money($item->pagado)</td>
                            <td>{{$item->notas ? $item->notas : "N/A"}}</td>
                            <td>
                                <button wire:click="mdlRegistrarPagoDestajo({{$item->id}})" class="btn btn-xs btn-success" wire:click=""><i class="fa fa-money-bill"></i> Registrar Pago</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
