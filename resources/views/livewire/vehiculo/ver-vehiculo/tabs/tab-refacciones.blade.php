<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">

        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cubes"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total Partes / Refacciones:</b></span>
                      <span class="info-box-number">@money($this->vehiculo->total_partes)</span>
                    </div>

                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-xs m-2" data-toggle="modal" data-target="#mdlCreateParte"><i class="fa fa-plus"></i> Registrar Parte</button>
        
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Fecha Creación</th>
                        <th>Concepto</th>
                        <th>Fecha de Compra</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->vehiculo->partes as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->descripcion}}</td>
                            <td>{{$item->fecha_format}}</td>
                            <td>{{$item->cantidad}}</td>
                            <td>@money($item->importe)</td>
                            <td><button class="btn btn-danger btn-xs" onclick="destroy({{$item->id}}, 'Parte', 'deleteParte')" ><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
