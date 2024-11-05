
@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('entrada.crear-cita-reparacion')
    @livewire('cliente.common.mdl-select-cliente')
@endsection
