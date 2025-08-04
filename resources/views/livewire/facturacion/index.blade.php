@extends('adminlte::page')

@section('title', 'Facturación Semanal')

@section('content_header')
    <h1>Facturación Semanal</h1>
@stop

@section('content')
    <div class="container-fluid">
        @livewire('facturacion.facturacion-semanal')
    </div>
@stop

@section('css')
    <style>
        .card-header h4 {
            margin-bottom: 0;
        }
        
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@stop

 