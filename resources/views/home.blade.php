@extends('adminlte::page')

@section('content')
<div class="bg-container">
{{-- @include('shared.system.loader') --}}
<br><br><br>
<center>
    <div class="mt-5 logo-container">
        <img width="60%" src="{{ asset('images/logo.png') }}">
    <h1 style="font-size: 2rem; color: black;">{{env('BUSSINESS_DESCRIPTION')}}</h1>

    </div>
    {{-- <h1>{{env('APP_FULL_NAME')}}</h1> --}}
    {{-- <h2 class="text-white" style="font-size: 1.5rem;">{{env('BUSSINESS_DESCRIPTION')}}</h2> --}}
    {{-- <br>
    <br>
    <h3><a href="/aos/tickets-soporte">Solicitud de soporte para errores y/o modificaciones</a></h3> --}}
</center>
</div>
@endsection

@section('css')
<style>
    .content-wrapper {
        background-image: url('{{ asset('images/bg.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    
    .content-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        opacity: 0.2;
        z-index: 0;
    }
    
    .bg-container {
        position: relative;
        z-index: 1;
    }
    
    .logo-container {
        background-color: rgba(255, 255, 255, 0.6);
        display: inline-block;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('js')
<script>
    $('body').removeClass('sidebar-collapse');
</script>
@endsection
