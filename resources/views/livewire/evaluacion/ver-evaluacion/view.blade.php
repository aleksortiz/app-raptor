<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="pl-3 pt-3">Evaluación: #{{ $this->evaluacion->id_paddy }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a href="/evaluaciones" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : '' }}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-car"></i> Datos Generales</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : '' }}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-file"></i> Documentos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : '' }}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-wrench"></i> Refacciones</a></li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">

                    <div class="tab-pane {{ $activeTab == 1 ? 'active' : '' }}" id="tab_1">
                        @include('livewire.evaluacion.ver-evaluacion.tabs.tab-data')
                    </div>

                    <div class="tab-pane {{ $activeTab == 2 ? 'active' : '' }}" id="tab_1">
                        @include('livewire.evaluacion.ver-evaluacion.tabs.tab-documentos')
                    </div>

                    <div class="tab-pane {{ $activeTab == 3 ? 'active' : '' }}" id="tab_3">
                        @include('livewire.evaluacion.ver-evaluacion.tabs.tab-refacciones')
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('livewire.evaluacion.ver-evaluacion.modals.mdl-edit')
    @include('livewire.evaluacion.ver-evaluacion.modals.mdl-upload-doc')
    @include('livewire.evaluacion.ver-evaluacion.modals.mdl-refacciones')
</div>
