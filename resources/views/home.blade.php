@extends('adminlte::page')

@section('content')
@include('shared.system.loader')
<br><br><br>
<center>
    <img width="60%" src="{{ asset('images/logo.png') }}">
    {{-- <h1>{{env('APP_FULL_NAME')}}</h1> --}}
    <h1>Autoservicio Raptor</h1>
    <h2>{{env('BUSSINESS_DESCRIPTION')}}</h2>
    {{-- <br>
    <br>
    <h3><a href="/aos/tickets-soporte">Solicitud de soporte para errores y/o modificaciones</a></h3> --}}
</center>
@endsection

@section('js')
<script>
    $('body').removeClass('sidebar-collapse');
</script>
@endsection
