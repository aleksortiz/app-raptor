<div>
    @section('meta_tags')
        <meta property="og:title" content="{{ $this->vehiculo->descripcion ?? 'Vehículo a la venta' }}">
        <meta property="og:description" content="{{ $this->vehiculo->descripcion_venta ?? 'Descripción por defecto' }}">
        <meta property="og:image" content="{{ $this->vehiculo->fotos_publicas[0]?->location_thumb ?? asset('images/logogv.png') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">

        <!-- Para Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $this->vehiculo->descripcion ?? 'Vehículo a la venta' }}">
        <meta name="twitter:description" content="{{ $this->vehiculo->descripcion_venta ?? 'Descripción por defecto' }}">
        <meta name="twitter:image" content="{{ $this->vehiculo->fotos_publicas[0]?->location_thumb ?? asset('images/logogv.png') }}">
    @endsection
    
    <style>
        body {
            display: flex;
            justify-content: center;  /* Centrar horizontalmente */
            align-items: center;  /* Centrar verticalmente */
            height: 100vh;  /* Ajustar al 100% de la pantalla */
            margin: 0;
            background-color: #f4f4f4;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 10px;
            padding: 10px;
            width: 90%; /* Ajustar el ancho para que no ocupe toda la pantalla */
            max-width: 800px; /* Limitar el ancho máximo */
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            text-align: center;
        }

        .grid-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover
        }

    </style>

    <center>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Vehículo</h3>
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $this->vehiculo->modelo }} {{$this->vehiculo->year}}</h1>
                <h3 class="text-center">Marca: {{ $this->vehiculo->marca }}</h3>
                <h3 class="text-center">Modelo: {{ $this->vehiculo->modelo }}</h3>
                <h3 class="text-center">Año: {{ $this->vehiculo->year }}</h3>
                <h3 class="text-center">Venta: @money($this->vehiculo->nombre_proveedor)</h3>
                
                {{-- <center> --}}
                    <div class="mt-2 grid-container">
                        @if ($this->vehiculo->fotos_publicas->isEmpty())
                            <h3 class="p-3 text-center text-danger">No hay fotos disponibles</h3>
                        @endif
                        
                        @foreach ($this->vehiculo->fotos_publicas ?? [] as $image)
                            <img src="{{ $image->url }}" class="img-fluid mb-2" alt="image" />
                        @endforeach
                    </div>
                {{-- </center> --}}


                @if ($this->vehiculo->descripcion_venta)
                    <div class="mt-3">
                        <h3>Más detalles:</h3>
                        <p class="text-center">{{ $this->vehiculo->descripcion_venta }}</p>
                    </div>
                @endif

                <center class="mt-5">
                    <a class="btn btn-success btn-lg" href="https://wa.me/5216563817465?text=Hola,%20me%20gustaría%20obtener%20más%20información." target="_blank">
                        <i class="fab fa-whatsapp fa-2x"></i> Pedir Información
                    </a>
                </center>
            </div>
        </div>
    </center>
</div>

