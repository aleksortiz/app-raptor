@extends('adminlte::page')

@section('content')
    @livewire('refaccion.ver-refaccion', ['refaccion_id' => $refaccion_id])
@endsection 