<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">

        <button class="btn btn-danger btn-xs m-2" data-toggle="modal" data-target="#mdlCreateGasto"><i class="fa fa-plus"></i> Registrar Gasto</button>
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>#</th>
                        <th>Fecha Creación</th>
                        <th>Usuario</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->gastos as $item)
                        <tr>
                            <td><button onclick="destroy({{$item->id}}, 'Gasto', 'deleteGasto')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->concepto}}</td>
                            <td>@money($item->monto)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
