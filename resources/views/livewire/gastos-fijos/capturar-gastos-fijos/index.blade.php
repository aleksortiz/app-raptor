@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('gastos-fijos.capturar-gastos-fijos')
@endsection
