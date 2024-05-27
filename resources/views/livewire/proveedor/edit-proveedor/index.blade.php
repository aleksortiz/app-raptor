@extends('adminlte::page')

@section('content')

    @include('shared.system.loader')     
    @livewire('proveedor.edit-proveedor', ['proveedor' => $proveedor ])
@endsection