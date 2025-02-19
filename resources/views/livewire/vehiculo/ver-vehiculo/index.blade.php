
@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/ekko-lightbox/ekko-lightbox.css')}}">
@endsection

@section('content')
    @include('shared.system.loader')
    @livewire('vehiculo.ver-vehiculo', ['id' => $id])
@endsection

@section('js')
    <script src="{{asset('vendor/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
    <script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
        });
        });
    })
    </script>
@endsection
