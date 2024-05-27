@extends('adminlte::page')

@section('content')

    @include('shared.system.loader')     
    @livewire('cliente.edit-cliente', ['cliente' => $cliente ])
@endsection