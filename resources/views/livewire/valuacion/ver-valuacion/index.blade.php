@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('valuacion.ver-valuacion', ['id' => $id])
@endsection
