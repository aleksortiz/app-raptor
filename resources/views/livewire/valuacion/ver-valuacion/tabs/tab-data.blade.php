<div class="card m-0" style="min-height: 65vh;">
    <div style="overflow: scroll;" class="card-body">
        <div class="row">
            <div class="col-3">
                <h3>{{ $valuacion->vehiculo }}</h3>
                </h5>
                <hr>

                <h5 style="cursor: pointer" wire:click="$set('activeTab', 4)"><b>Cliente:</b><br>
                    {{ $valuacion->cliente->nombre }}</h5>
                <hr>

                <h5><b>No. Reporte:</b><br> {{ $valuacion->numero_reporte }}</h5>
                <hr>

                <h5><b>Fecha de cita:</b><br> {{ $valuacion->fecha_cita_span }}</h5>
                <hr>

                <h5><b>Registrado por:</b><br> {{ $valuacion->user->name }}</h5>
                <hr>

                @if ($valuacion->notas)
                    <h5><b>Notas:</b><br> {{ $valuacion->notas }}</h5>
                    <hr>
                @endif



            </div>
            <div class="col-9">
              @include('livewire.valuacion.ver-valuacion.tabs.tab-presupuestos')
            </div>

        </div>


    </div>

    <div class="card-footer">
        {{-- <a class="btn btn-warning" href="/servicios/{{ $this->valuacion->id }}/editar"><i class="fas fa-edit"></i> Editar Valuación</a> --}}
    </div>
</div>
