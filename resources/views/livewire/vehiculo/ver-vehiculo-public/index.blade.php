
@extends('layouts.public')


@section('content')
    @livewire('vehiculo.ver-vehiculo-public', ['id' => $id])
@endsection
