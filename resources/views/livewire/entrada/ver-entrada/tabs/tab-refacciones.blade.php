<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">


        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Costo:</b></span>
                        <span class="info-box-number">@money($this->entrada->total_costo_refacciones)</span>
                    </div>

                </div>
            </div>

            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-wrench"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Venta Refacciones:</b></span>
                        <span class="info-box-number">@money($this->entrada->total_refacciones)</span>
                    </div>

                </div>
            </div>

            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Utilidad:</b></span>
                        <span class="info-box-number">@money($this->entrada->total_utilidad_refacciones)</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- <button wire:click="showMdlRefacciones" class="m-2 btn btn-xs btn-success"><i class="fa fa-plus"></i> Agregar Refacción</button> --}}

        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Fecha</th>
                            <th>Número de Parte</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            {{-- <th>Cantidad</th> --}}
                            @if ($this->entrada->venta_refacciones)
                                <th>Precio</th>
                            @endif
                            <th>Importe</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->refacciones as $item)
                        <tr>
                            {{-- <td><button class="btn btn-xs btn-danger" onclick="destroy({{$item->id}},'refacción','destroyRefaccion')"><i class="fa fa-trash-alt"></i></button></td> --}}
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->numero_parte}}</td>
                            <td>{{$item->descripcion}}</td>
                            <td>@money($item->costo)</td>
                            {{-- <td>{{$item->cantidad}}</td> --}}
                            @if ($this->entrada->venta_refacciones)
                                <td>@money($item->precio)</td>
                            @endif
                            <td>@money($item->importe)</td>
                            <td><button class="btn btn-xs btn-warning" wire:click="mdlEditarRefaccion({{ $item->id }})"><i class="fa fa-edit"></i> Editar</button></td>

                        </tr>
                        @endforeach

                        @foreach ($this->entrada->costos as $costo)
                          @foreach ($costo->refacciones as $item)

                          <tr>
                              {{-- <td><button class="btn btn-xs btn-danger" onclick="destroy({{$item->id}},'refacción','destroyRefaccion')"><i class="fa fa-trash-alt"></i></button></td> --}}
                              <td>{{$item->fecha_creacion}}</td>
                              <td>{{$item->numero_parte}}</td>
                              <td>{{$item->descripcion}}</td>
                              <td>@money($item->costo)</td>
                              {{-- <td>{{$item->cantidad}}</td> --}}
                              @if ($this->entrada->venta_refacciones)
                                  <td>@money($item->precio)</td>
                              @endif
                              <td>@money($item->importe)</td>
                              <td><button class="btn btn-xs btn-warning" wire:click="mdlEditarRefaccion({{ $item->id }})"><i class="fa fa-edit"></i> Editar</button></td>

                          </tr>

                          @endforeach

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
