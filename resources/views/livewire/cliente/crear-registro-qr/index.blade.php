@extends('layouts.public')


@section('content')
    @include('shared.system.loader')
    @livewire('cliente.crear-registro-qr')
@endsection