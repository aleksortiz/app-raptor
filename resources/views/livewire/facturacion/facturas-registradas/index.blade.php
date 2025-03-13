@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('facturacion.facturas-registradas')
@endsection
