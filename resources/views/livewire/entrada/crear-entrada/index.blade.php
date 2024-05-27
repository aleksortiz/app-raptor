@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('entrada.crear-entrada')
    @livewire('cliente.common.mdl-select-cliente')
@endsection