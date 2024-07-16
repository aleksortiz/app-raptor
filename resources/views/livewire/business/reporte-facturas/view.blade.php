<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h5>Facturas Pendientes</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Creación</th>
                        <th>Folio</th>
                        <th>Concepto</th>
                        <th>Venta</th>
                        <th>Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through the invoices --}}
                    @foreach ($servicios as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->fecha_creacion }}</td>
                        <td>{{ $item->model->folio_short }}</td>
                        <td>@money($item->costo)</td>
                        <td>{{ $item->pagado ?? "PENDIENTE" }}</td>
                        <td>{{ $item->no_factura ?? "PENDIENTE" }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>