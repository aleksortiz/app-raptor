<div class="pt-2">

    <div style="height: 75vh;" class="card">
        <div class="card-header">
            <h3 class="card-title">YYYYYY</h3>
        </div>
        <div class="card-body p-0">
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Costo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([] as $row)
                    <tr>
                        <td>{{ $row->tipo_servicio }}</td>
                        <td>{{ $row->descripcion }}</td>
                        <td>{{ $row->fecha }}</td>
                        <td>@money($row->costo)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    
        </div>
    </div>

</div>
