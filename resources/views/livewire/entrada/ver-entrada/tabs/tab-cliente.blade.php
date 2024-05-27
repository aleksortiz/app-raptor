<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        
        <div class="row">
            <div class="col-4">
                <a class="mb-2 btn btn-sm btn-success" target="_blank" href="/clientes/{{$this->entrada->cliente_id}}"><i class="fa fa-user"></i> Ver Cliente</a>
                <h5><b>Nombre:</b> {{$this->entrada->cliente->nombre}}</h5>
                <hr>
                <h5><b>Teléfono:</b> {{$this->entrada->cliente->telefono}}</h5>
                <hr>
                <h5><b>Dirección:</b> {{$this->entrada->cliente->direccion}}</h5>
                <hr>
                @if ($this->entrada->cliente->razon_social)    
                    <h5><b>Razón Social:</b> {{$this->entrada->cliente->razon_social}}</h5>
                    <hr>
                @endif
                @if ($this->entrada->cliente->rfc)    
                    <h5><b>RFC:</b> {{$this->entrada->cliente->rfc}}</h5>
                <hr>
            @endif
            </div>
            <div class="col-8">
                <h5>Servicios Registrados</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Origen</th>
                            <th>Vehículo</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->cliente->entradas as $item)
                        <tr>
                            @if ($this->entrada->id == $item->id)
                                <td>{{$item->folio_short}}</td>
                            @else
                                <td><a href="/servicios/{{$item->id}}" target="_blank" class="btn btn-primary btn-sm">{{$item->folio_short}}</a></td>
                            @endif
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->origen}}</td>
                            <td>{{$item->vehiculo}}</td>
                            <td>@money($item->total)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>