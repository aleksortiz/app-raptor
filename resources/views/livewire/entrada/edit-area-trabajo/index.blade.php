@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('entrada.edit-area-trabajo', ['entrada' => $entrada])
@endsection
