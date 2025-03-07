
@extends('adminlte::master')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('body')
    <div class="m-0 wrapper">
        <div>
            <div class="m-4 content">
                {{ $slot }}
            </div>
        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
