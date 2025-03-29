<div>


    @section('content_header')
        <h1>Prestamos</h1>
    @stop

    @livewire('personal.mdl-crear-prestamo')
    @include('livewire.personal.catalogo-prestamos.mdl')


    <button class="btn btn-xs btn-success" wire:click="$emit('showModal', '#mdlCrearPrestamo')"><i class="fa fa-hand-holding-usd"></i> Registrar Prestamo</button>

    <table class="mt-3 table table-hover">
        <thead>
            <tr>
                <th>Imprimir</th>
                <th>Fecha Creación</th>
                <th>Autorizado por:</th>
                <th>Personal</th>
                <th>Monto</th>
                <th>Cuota Semanal</th>
                <th>Coutas Pendientes</th>
                <th>Inicia</th>
                <th>Finaliza</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $item)
                <tr style="cursor: pointer" wire:click="showPrestamo({{ $item->id }})">
                    <td><button wire:click.stop="$emit('print', 'prestamo#{{$item->id}}')" class="btn btn-sm btn-default"><i class="fa fa-print"></i></button></td>
                    <td>{{ $item->fecha_creacion }}</td>
                    <td>{{ $item->user?->name }}</td>
                    <td>{{ $item->personal?->nombre }}</td>
                    <td>@money($item->monto)</td>
                    <td>@money($item->cuota_semanal)</td>
                    <td>{{ $item->cuotas_pendientes }} / {{ $item->cuotas }}</td>
                    <td>{{ $item->inicia }}</td>
                    <td>{{ $item->finaliza }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $prestamos->links() }} --}}
</div>


