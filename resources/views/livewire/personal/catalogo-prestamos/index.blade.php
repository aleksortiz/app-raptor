@extends('adminlte::page')

@section('title', __("Prestamos a Personal"))

@section('content')
    @include('shared.system.loader')
    @livewire('personal.catalogo-prestamos')
@endsection
