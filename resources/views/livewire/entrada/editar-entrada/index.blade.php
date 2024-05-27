@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('entrada.editar-entrada', ['entrada' => $entrada])
    @livewire('cliente.common.mdl-select-cliente')
@endsection
