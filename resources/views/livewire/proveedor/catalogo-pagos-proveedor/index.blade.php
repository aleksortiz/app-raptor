@section('title', __("Pagos a Proveedores"))
@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('proveedor.catalogo-pagos-proveedor')
@endsection
