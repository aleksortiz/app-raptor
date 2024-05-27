@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('fotos.subir-fotos', [
        'model' => $entrada,
        'storage_path' => 'evaluaciones/fotos'
    ])
@endsection