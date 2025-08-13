@extends('adminlte::page')

@section('title', 'Requisicion de Facturas')

@section('content_header')
    <h1>Requisiciones de Facturas</h1>
@stop

@section('content')
    <div class="container-fluid">
        @livewire('facturacion.crear-requisicion-factura')
    </div>
@stop

 