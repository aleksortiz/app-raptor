@extends('adminlte::page')

@section('title', 'Ver Cliente')

@section('content')
    <div class="container-fluid">
        @livewire('cliente.ver-cliente', ['cliente_id' => $cliente_id])
    </div>
@stop

 