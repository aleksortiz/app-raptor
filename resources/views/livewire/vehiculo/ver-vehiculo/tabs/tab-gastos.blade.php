<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">

        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total Gastos:</b></span>
                      <span class="info-box-number">@money($this->vehiculo->total_gastos)</span>
                    </div>

                </div>
            </div>
        </div>

        <button class="btn btn-danger btn-xs m-2" data-toggle="modal" data-target="#mdlCreateGasto"><i class="fa fa-plus"></i> Registrar Gasto</button>
        
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Fecha Creación</th>
                        <th>Concepto</th>
                        <th>Fecha de Operación</th>
                        <th>Monto</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->vehiculo->gastos as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->descripcion}}</td>
                            <td>{{$item->fecha_format}}</td>
                            <td>@money($item->monto)</td>
                            <td><button class="btn btn-danger btn-xs" onclick="destroy({{$item->id}}, 'Gasto', 'deleteGasto')" ><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
