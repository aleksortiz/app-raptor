@extends('adminlte::page')

@section('title', 'Vehículos Concluidos')

@section('content_header')
    <h1>Vehículos Concluidos</h1>
@stop

@section('content')
    <div class="container-fluid">
        <livewire:entrada.vehiculos-concluidos />
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop 