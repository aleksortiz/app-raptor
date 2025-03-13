<div>

    @section('content_header')
        <h1>Facturas Registradas</h1>
    @stop


    <h5><a href="/control-facturacion"><i class="fa fa-car"></i> Entradas Pendientes</a> / <i class="fa fa-file-alt"></i> Facturas Registradas ({{$data->count()}})</h5>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="search">Buscar</label>
                <input type="text" class="form-control" id="search" wire:model.lazy="search" placeholder="Buscar">
            </div>
        </div>
    </div>

    <table class="mt-3 table table-hover">
        <thead>
            <tr>
                <th>Creado</th>
                <th>No. Reporte</th>
                <th>No. Factura</th>
                <th>Monto</th>
                <th>Notas</th>
                <th>Fecha de Pago</th>
                <th>Corresponde a:</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr style="cursor: pointer">
                    <td>{{ $item->fecha_creacion }}</td>
                    <td>{{ $item->numero_reporte }}</td>
                    <td>{{ $item->numero_factura }}</td>
                    <td>@money($item->monto)</td>
                    <td>{{ $item->notas }}</td>
                    <td>{!! $item->fecha_pago_span !!}</td>
                    <td>{!! $item->model_span !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}


</div>


