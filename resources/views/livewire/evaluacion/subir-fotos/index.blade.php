@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('fotos.subir-fotos', [
        'model' => $evaluacion,
        'storage_path' => 'evaluaciones/fotos'
    ])
@endsection