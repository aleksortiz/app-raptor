<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <div>
                    <h4 class="pl-3 pt-3 m-0">{{ $vehiculo->descripcion_short }}</h4>
                </div>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link" style="cursor: pointer;" wire:click="back"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                    <li class="nav-item"><a class="nav-link {{ $tab == '' ? 'active' : '' }}" wire:click="$set('tab','')" style="cursor: pointer;"><i class="fas fa-car"></i> Info Gral.</a></li>
                    <li class="nav-item"><a class="nav-link {{ $tab == 'fotos' ? 'active' : '' }}" wire:click="$set('tab','fotos')" style="cursor: pointer;"><i class="fas fa-camera"></i> Fotos</a></li>
                    {{-- <li class="nav-item"><a class="nav-link {{ $tab == 'refacciones' ? 'active' : '' }}" wire:click="$set('tab','refacciones')" style="cursor: pointer;"><i class="fas fa-cubes"></i> Partes / Refacciones</a></li> --}}
                    {{-- <li class="nav-item"><a class="nav-link {{ $tab == 'gastos' ? 'active' : '' }}" wire:click="$set('tab','gastos')" style="cursor: pointer;"><i class="fas fa-hand-holding-usd"></i> Otros Gastos</a></li> --}}
                    <li class="nav-item"><a class="nav-link {{ $tab == 'compra-venta' ? 'active' : '' }}" wire:click="$set('tab','compra-venta')" style="cursor: pointer;"><i class="fas fa-handshake"></i> Compra / Venta</a></li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">

                    <div class="tab-pane {{ $tab == '' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-data')
                    </div>

                    <div class="tab-pane {{ $tab == 'fotos' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-fotos')
                    </div>

                    {{-- <div class="tab-pane {{ $tab == 'refacciones' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-refacciones')
                    </div> --}}

                    {{-- <div class="tab-pane {{ $tab == 'gastos' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-gastos')
                    </div> --}}

                    <div class="tab-pane {{ $tab == 'compra-venta' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-compra-venta')
                    </div>


                </div>
            </div>
        </div>
    </div>

    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-create-gasto')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-create-parte')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-send-mail')


    {{-- @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
    @include('livewire.entrada.ver-entrada.modals.mdl-create-costo')
    @include('livewire.entrada.ver-entrada.modals.mdl-material-manual')
    @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
    @include('livewire.entrada.ver-entrada.modals.mdl-registrar-pago-destajo')
    @livewire('material.common.select-material')
    @livewire('personal.mdl-crear-orden-trabajo', ['entrada_id' => $this->entrada->id]) --}}
</div>
