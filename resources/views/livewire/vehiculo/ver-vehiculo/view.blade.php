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
                    <li class="nav-item"><a class="nav-link {{ $tab == 'vehiculos-cuenta' ? 'active' : '' }}" wire:click="$set('tab','vehiculos-cuenta')" style="cursor: pointer;"><i class="fas fa-exchange-alt"></i> Vehiculos a Cuenta</a></li>
                    <li class="nav-item"><a class="nav-link {{ $tab == 'fotos' ? 'active' : '' }}" wire:click="$set('tab','fotos')" style="cursor: pointer;"><i class="fas fa-camera"></i> Fotos</a></li>
                    {{-- <li class="nav-item"><a class="nav-link {{ $tab == 'gastos' ? 'active' : '' }}" wire:click="$set('tab','gastos')" style="cursor: pointer;"><i class="fas fa-hand-holding-usd"></i> Otros Gastos</a></li> --}}
                    <li class="nav-item"><a class="nav-link {{ $tab == 'compra-venta' ? 'active' : '' }}" wire:click="$set('tab','compra-venta')" style="cursor: pointer;"><i class="fas fa-handshake"></i> Venta</a></li>
                    @if ($vehiculo->venta)
                        <li class="nav-item"><a class="nav-link {{ $tab == 'pagares' ? 'active' : '' }}" wire:click="$set('tab','pagares')" style="cursor: pointer;"><i class="fas fa-money-check"></i> Pagares</a></li>
                    @endif
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

                    <div class="tab-pane {{ $tab == 'vehiculos-cuenta' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-vehiculos-cuenta')
                    </div>

                    {{-- <div class="tab-pane {{ $tab == 'gastos' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-gastos')
                    </div> --}}

                    <div class="tab-pane {{ $tab == 'compra-venta' ? 'active' : '' }}">
                        @include('livewire.vehiculo.ver-vehiculo.tabs.tab-compra-venta')
                    </div>

                    @if ($vehiculo->venta)
                        <div class="tab-pane {{ $tab == 'pagares' ? 'active' : '' }}">
                            @include('livewire.vehiculo.ver-vehiculo.tabs.tab-pagares')
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-edit')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-create-gasto')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-create-parte')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-create-vehiculo-cuenta')
    @include('livewire.vehiculo.ver-vehiculo.modals.mdl-send-mail')

    @livewire('cliente.common.mdl-select-cliente')


    {{-- @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
    @include('livewire.entrada.ver-entrada.modals.mdl-create-costo')
    @include('livewire.entrada.ver-entrada.modals.mdl-material-manual')
    @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
    @include('livewire.entrada.ver-entrada.modals.mdl-registrar-pago-destajo')
    @livewire('material.common.select-material')
    @livewire('personal.mdl-crear-orden-trabajo', ['entrada_id' => $this->entrada->id]) --}}
</div>
