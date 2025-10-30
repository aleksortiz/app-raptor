<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
                    <h4 class="pl-3 pt-3 m-0">Folio: {{ $entrada->folio_short }}</h4>
                    <label class="pl-3">{{ $entrada->vehiculo }}</label>
                </div>
                <ul class="nav nav-pills ml-auto p-2">
                    {{-- <li class="nav-item"><a href="/servicios" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li> --}}
                    <li class="nav-item"><a class="nav-link" style="cursor: pointer;" wire:click="back"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : '' }}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-car"></i> Info Gral.</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : '' }}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-dollar-sign"></i> Servicios</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : '' }}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-camera"></i> Fotos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : '' }}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-user"></i> Cliente</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 5 ? 'active' : '' }}" wire:click="$set('activeTab',5)" href="#"><i class="fas fa-wrench"></i> Refacciones</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 6 ? 'active' : '' }}" wire:click="$set('activeTab',6)" href="#"><i class="fas fa-cubes"></i> Materiales</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 7 ? 'active' : '' }}" wire:click="$set('activeTab',7)" href="#"><i class="fas fa-hand-holding-usd"></i> Sueldos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 8 ? 'active' : '' }}" wire:click="$set('activeTab',8)" href="#"><i class="fas fa-hand-holding-usd"></i> Destajos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 9 ? 'active' : '' }}" wire:click="$set('activeTab',9)" href="#"><i class="fas fa-money-bill"></i> Gastos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 13 ? 'active' : '' }}" wire:click="$set('activeTab',13)" href="#"><i class="fas fa-clipboard-check"></i> Valuaciones</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 10 ? 'active' : '' }}" wire:click="$set('activeTab',10)" href="#"><i class="fas fa-tasks"></i> Asignaciones</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 11 ? 'active' : '' }}" wire:click="$set('activeTab',11)" href="#"><i class="fas fa-arrow-right"></i> Avance</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 12 ? 'active' : '' }}" wire:click="$set('activeTab',12)" href="#"><i class="fas fa-file"></i> Documentos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 14 ? 'active' : '' }}" wire:click="$set('activeTab',14)" href="#"><i class="fas fa-video"></i> Videos</a></li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">

                    <div class="tab-pane {{ $activeTab == 1 ? 'active' : '' }}" id="tab_1">
                        @include('livewire.entrada.ver-entrada.tabs.tab-data')
                    </div>

                    <div class="tab-pane {{ $activeTab == 2 ? 'active' : '' }}" id="tab_2">
                        @include('livewire.entrada.ver-entrada.tabs.tab-servicios')
                    </div>

                    <div class="tab-pane {{ $activeTab == 3 ? 'active' : '' }}" id="tab_3">
                        @include('livewire.entrada.ver-entrada.tabs.tab-fotos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 4 ? 'active' : '' }}" id="tab_4">
                        @include('livewire.entrada.ver-entrada.tabs.tab-cliente')
                    </div>

                    <div class="tab-pane {{ $activeTab == 5 ? 'active' : '' }}" id="tab_5">
                        @include('livewire.entrada.ver-entrada.tabs.tab-refacciones')
                    </div>

                    <div class="tab-pane {{ $activeTab == 6 ? 'active' : '' }}" id="tab_6">
                        @include('livewire.entrada.ver-entrada.tabs.tab-materiales')
                    </div>

                    <div class="tab-pane {{ $activeTab == 7 ? 'active' : '' }}" id="tab_7">
                        @include('livewire.entrada.ver-entrada.tabs.tab-sueldos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 8 ? 'active' : '' }}" id="tab_8">
                        @include('livewire.entrada.ver-entrada.tabs.tab-destajos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 9 ? 'active' : '' }}" id="tab_9">
                        @include('livewire.entrada.ver-entrada.tabs.tab-gastos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 10 ? 'active' : '' }}" id="tab_10">
                        @include('livewire.entrada.ver-entrada.tabs.tab-asignaciones')
                    </div>

                    <div class="tab-pane {{ $activeTab == 11 ? 'active' : '' }}" id="tab_11">
                        @include('livewire.entrada.ver-entrada.tabs.tab-avance')
                    </div>

                    <div class="tab-pane {{ $activeTab == 12 ? 'active' : '' }}" id="tab_12">
                        @include('livewire.entrada.ver-entrada.tabs.tab-documentos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 13 ? 'active' : '' }}" id="tab_13">
                        @include('livewire.entrada.ver-entrada.tabs.tab-valuaciones')
                    </div>

                    <div class="tab-pane {{ $activeTab == 14 ? 'active' : '' }}" id="tab_14">
                        @include('livewire.entrada.ver-entrada.tabs.tab-videos')
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('livewire.entrada.ver-entrada.modals.mdl-comentarios')
    @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
    @include('livewire.entrada.ver-entrada.modals.mdl-create-costo')
    @include('livewire.entrada.ver-entrada.modals.mdl-create-gasto')
    @include('livewire.entrada.ver-entrada.modals.mdl-material-manual')
    @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
    @include('livewire.entrada.ver-entrada.modals.mdl-registrar-pago-destajo')
    @livewire('material.common.select-material')
    @livewire('personal.mdl-crear-orden-trabajo', ['entrada_id' => $this->entrada->id])
    @livewire('entrada.ver-entrada.modals.crear-asignacion', ['entrada_id' => $this->entrada->id])
    @livewire('entrada.ver-entrada.modals.editar-asignacion')
</div>