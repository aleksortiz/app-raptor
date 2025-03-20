<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">


        {{-- <button class="btn btn-primary btn-xs m-2" data-toggle="modal" data-target="#mdlCreateVehiculoCuenta"><i class="fa fa-plus"></i> Registrar Vehiculo</button> --}}
        
        <div class="row justify-content-center">
            <div class="col-8">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pagaré</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Tasa de Interés</th>
                            <th>Estatus</th>
                            <th>Imprimir</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->vehiculo->pagares as $item)
                            <tr>
                                <td>{{$item->numero_pagare}}</td>
                                <td>{{$item->fecha_pagare_format}}</td>
                                <td>@money($item->monto)</td>
                                <td>{{$item->tasa_interes}}%</td>
                                <td>{!! $item->estatus_span !!}</td>
                                <td><a href="/vehiculos/pagare/{{$item->id}}" target="_blank" class="btn btn-secondary btn-xs"><i class="fa fa-money-check"></i> Ver Pagaré</a></td>
                                <td><button class="btn btn-danger btn-xs" onclick="destroy({{$item->id}}, 'Vehiculo a cuenta', 'deleteVehiculoCuenta')" ><i class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
