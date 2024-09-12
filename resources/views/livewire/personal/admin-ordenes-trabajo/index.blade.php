@extends('adminlte::page')

@section('title', __("Ordenes de Trabajo"))

@section('content')
    @include('shared.system.loader')
    @livewire('personal.admin-ordenes-trabajo')
@endsection
