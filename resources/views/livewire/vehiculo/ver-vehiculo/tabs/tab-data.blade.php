<div class="card m-0" style="min-height: 65vh;">
    <div style="overflow: scroll;" class="card-body">
        <div class="row">
            <div class="col-3">

                <h5><b>Marca:</b><br>{{ $vehiculo->marca }}</h5>
                <hr>

                <h5><b>Modelo:</b><br> {{ $vehiculo->modelo }}</h5>
                <hr>

                <h5><b>Año:</b><br> {{ $vehiculo->year }}</h5>
                <hr>

                <h5><b>Precio Venta:</b><br> {{ $vehiculo->precio_venta }} MXN</h5>
                <hr>

                @if ($vehiculo->placa)
                    <h5><b>Placa:</b><br> {{ $vehiculo->placa }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->serie)
                    <h5><b>Serie:</b><br> {{ $vehiculo->serie }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->factura)
                    <h5><b>Factura:</b><br> {{ $vehiculo->factura }}</h5>
                    <hr>
                @endif

                @if ($vehiculo->pedimento)
                    <h5><b>Pedimento:</b><br> {{ $vehiculo->pedimento }}</h5>
                    <hr>
                @endif


            </div>
            <div class="col-9">



            </div>
        </div>


    </div>

    {{-- <div class="card-footer">
        <a class="btn btn-warning" href="/servicios/{{ $this->vehiculo->id }}/editar"><i class="fas fa-edit"></i> Editar
            Entrada</a>
    </div> --}}
</div>
