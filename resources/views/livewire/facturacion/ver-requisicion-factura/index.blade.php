@extends('adminlte::page')

@section('title', 'Detalles de Requisición de Factura')

@section('content_header')
    <h1>
        <i class="fas fa-file-invoice-dollar mr-2"></i>
        Detalles de Requisición de Factura
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        @livewire('facturacion.ver-requisicion-factura', ['id' => $id])
    </div>
@stop
