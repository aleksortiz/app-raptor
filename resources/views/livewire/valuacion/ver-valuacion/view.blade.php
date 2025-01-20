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
                  <li class="nav-item"><a class="nav-link {{ $tab == '' ? 'active' : '' }}" wire:click="$set('tab','')" href="#"><i class="fas fa-car"></i> Valuación</a></li>
                  {{-- <li class="nav-item"><a class="nav-link {{ $tab == 'cliente' ? 'active' : '' }}" wire:click="$set('tab','cliente')" href="#"><i class="fas fa-user"></i> Cliente</a></li> --}}
                  <li class="nav-item"><a class="nav-link {{ $tab == 'fotos' ? 'active' : '' }}" wire:click="$set('tab','fotos')" href="#"><i class="fas fa-camera"></i> Fotos</a></li>

              </ul>
          </div>

          <div class="card-body p-0">
              <div class="tab-content">

                  <div class="tab-pane {{ $tab == '' ? 'active' : '' }}" id="tab_1">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-data')
                  </div>
{{-- 
                  <div class="tab-pane {{ $tab == 'cliente' ? 'active' : '' }}" id="tab_2">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-cliente')
                  </div> --}}

                  <div class="tab-pane {{ $tab == 'fotos' ? 'active' : '' }}" id="tab_3">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-fotos')
                  </div>


              </div>
          </div>
      </div>
  </div>


  @livewire('foto.mdl-upload-mobile-photos', ['model_id' => $valuacion->id, 'model_type' => 'App\\Models\\Valuacion', 'storage_path' => "/valuaciones/{$valuacion->id}"])

  {{-- @include('livewire.entrada.ver-entrada.modals.mdl-refacciones')
  @include('livewire.entrada.ver-entrada.modals.mdl-create-costo')
  @include('livewire.entrada.ver-entrada.modals.mdl-create-gasto')
  @include('livewire.entrada.ver-entrada.modals.mdl-material-manual')
  @include('livewire.entrada.ver-entrada.modals.mdl-edit-date')
  @include('livewire.entrada.ver-entrada.modals.mdl-registrar-pago-destajo')
  @livewire('material.common.select-material')
  @livewire('personal.mdl-crear-orden-trabajo', ['entrada_id' => $this->entrada->id]) --}}
</div>
