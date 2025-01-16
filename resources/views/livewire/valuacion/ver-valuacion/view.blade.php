<div class="row pt-4">
  <div class="col-12">
      <div class="card">

          <div class="card-header d-flex p-0">
              <div>
                  <h4 class="pl-3 pt-3 m-0">Valuación: #{{ $valuacion->id_paddy }}</h4>
                  <label class="pl-3">{{ $valuacion->fecha_creacion }}</label>
              </div>
              <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link" style="cursor: pointer;" wire:click="back"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                  <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : '' }}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-car"></i> Valuación</a></li>
                  <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : '' }}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-user"></i> Cliente</a></li>
                  <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : '' }}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-camera"></i> Fotos</a></li>

              </ul>
          </div>

          <div class="card-body p-0">
              <div class="tab-content">

                  <div class="tab-pane {{ $activeTab == 1 ? 'active' : '' }}" id="tab_1">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-data')
                  </div>

                  <div class="tab-pane {{ $activeTab == 2 ? 'active' : '' }}" id="tab_2">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-cliente')
                  </div>

                  <div class="tab-pane {{ $activeTab == 3 ? 'active' : '' }}" id="tab_3">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-fotos')
                  </div>


              </div>
          </div>
      </div>
  </div>

  {{-- @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
  @include('livewire.entrada.ver-entrada.modals.mdl-create-costo')
  @include('livewire.entrada.ver-entrada.modals.mdl-create-gasto')
  @include('livewire.entrada.ver-entrada.modals.mdl-material-manual')
  @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
  @include('livewire.entrada.ver-entrada.modals.mdl-registrar-pago-destajo')
  @livewire('material.common.select-material')
  @livewire('personal.mdl-crear-orden-trabajo', ['entrada_id' => $this->entrada->id]) --}}
</div>
