@extends('adminlte::page')

@section('content')

    @include('shared.system.loader')     
    @livewire('cliente.catalogo-citas-qr')
    
@endsection