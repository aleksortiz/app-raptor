@extends('layouts.public')


@section('content')
    @include('shared.system.loader')
    @livewire('entrada.final-checklist', ['entrada' => $entrada])
@endsection
