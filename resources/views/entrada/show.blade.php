@extends('layouts.public')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Detalles de Entrada - {{ $entrada->folio }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Información General</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="bg-light">Vehículo</th>
                                                <td>{{ $entrada->vehiculo }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Serie</th>
                                                <td>{{ $entrada->serie }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Cliente</th>
                                                <td>{{ $entrada->cliente->nombre ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Estado</th>
                                                <td>{!! $entrada->estado_button !!}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Tarea a Realizar</th>
                                                <td>{{ $entrada->tarea_realizar }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Foto Principal</h5>
                                    <div class="text-center">
                                        <img src="{{ $entrada->main_photo }}" class="img-fluid rounded" style="max-height: 300px;" alt="Foto principal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Galería de Fotos</h5>
                                    <div class="row g-3">
                                        @foreach($entrada->fotos as $foto)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="position-relative">
                                                <a href="{{ $foto->complete_url }}" target="_blank" data-lightbox="entrada-gallery" data-title="Foto {{ $loop->iteration }}">
                                                    <img src="{{ $foto->complete_thumb_url }}" class="img-fluid rounded shadow-sm w-100" style="height: 200px; object-fit: cover;" alt="Foto {{ $loop->iteration }}">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($entrada->avance)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Estado del Avance</h5>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                            style="width: {{ $entrada->avance->porcentaje }}%;" 
                                            aria-valuenow="{{ $entrada->avance->porcentaje }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ $entrada->avance->porcentaje }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Imagen %1 de %2"
    });
</script>
@endpush
@endsection 