<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">

        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-exchange-alt"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total vehículos a cuenta:</b></span>
                      <span class="info-box-number">@money($this->vehiculo->suma_vehiculos_cuenta)</span>
                    </div>

                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-xs m-2" data-toggle="modal" data-target="#mdlCreateVehiculoCuenta"><i class="fa fa-plus"></i> Registrar Vehiculo</button>
        
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha</th>
                            <th>Vehiculo</th>
                            <th>Vendedor</th>
                            <th>Monto</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->vehiculo->vehiculos_cuenta as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->fecha_format}}</td>
                                <td>{{$item->descripcion}}</td>
                                <td>{{$item->vendedor}}</td>
                                <td>@money($item->monto)</td>
                                <td><button class="btn btn-danger btn-xs" onclick="destroy({{$item->id}}, 'Vehiculo a cuenta', 'deleteVehiculoCuenta')" ><i class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
