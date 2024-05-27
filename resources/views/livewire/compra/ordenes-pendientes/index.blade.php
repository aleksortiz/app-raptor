@extends('adminlte::page')
@section('title', __('Ordenes Pendientes'))


@section('content')
    @include('shared.system.loader')


    <div class="pt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ordenes pendientes de autorización</h3>
            </div>
            <div class="card-body p-0">
                @livewire('compra.common.ordenes-pendientes')
            </div>
        </div>
    </div>



@endsection