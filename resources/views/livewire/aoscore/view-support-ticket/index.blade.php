@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')
    @livewire('aoscore.view-support-ticket', ['ticket' => $ticket])
@endsection