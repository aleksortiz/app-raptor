@extends('adminlte::page')

@section('title', 'Reporte de Finanzas V2')

@section('content_header')
    <h1>Reporte de Finanzas V2</h1>
@stop

@section('content')
    @livewire('business.finance-dashboard-v2')
@stop