<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="pl-3 pt-3">Folio: {{ $entrada->folio_short }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a href="/servicios" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : '' }}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-car"></i> Datos Generales</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : '' }}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-dollar-sign"></i> Servicios</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : '' }}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-camera"></i> Fotos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : '' }}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-user"></i> Cliente</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 5 ? 'active' : '' }}" wire:click="$set('activeTab',5)" href="#"><i class="fas fa-wrench"></i> Refacciones</a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 6 ? 'active' : '' }}" wire:click="$set('activeTab',6)" href="#"><i class="fas fa-cubes"></i> Materiales</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 7 ? 'active' : '' }}" wire:click="$set('activeTab',7)" href="#"><i class="fas fa-hand-holding-usd"></i> Sueldos</a></li>
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

                    <div class="tab-pane {{ $activeTab == 7 ? 'active' : '' }}" id="tab_6">
                        @include('livewire.entrada.ver-entrada.tabs.tab-sueldos')
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
    @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
    @livewire('material.common.select-material')
</div>
