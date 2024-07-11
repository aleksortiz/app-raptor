
@extends('layouts.public')

@section('content')
    @include('shared.system.loader')
    @livewire('flotilla.catalogo-flotillas', ['identificador' => $identificador])
@endsection
