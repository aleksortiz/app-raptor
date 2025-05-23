@extends('adminlte::page')

@section('title', 'Dashboard Financiero V2')

@section('content_header')
    <h1>Dashboard Financiero V2</h1>
@stop

@section('content')
    @livewire('business.finance-dashboard-v2')
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>
@stop 