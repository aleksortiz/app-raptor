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
                  <li class="nav-item"><a class="nav-link {{ $tab == 'editar' ? 'active' : '' }}" wire:click="$set('tab','editar')" href="#"><i class="fas fa-edit"></i> Editar</a></li>
                  {{-- <li class="nav-item"><a class="nav-link {{ $tab == 'cliente' ? 'active' : '' }}" wire:click="$set('tab','cliente')" href="#"><i class="fas fa-user"></i> Cliente</a></li> --}}
                  <li class="nav-item"><a class="nav-link {{ $tab == 'fotos' ? 'active' : '' }}" wire:click="$set('tab','fotos')" href="#"><i class="fas fa-camera"></i> Fotos</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab == 'docs' ? 'active' : '' }}" wire:click="$set('tab','docs')" href="#"><i class="fas fa-file"></i> Documentos</a></li>
              </ul>
          </div>

          <div class="card-body p-0">
              <div class="tab-content">

                  <div class="tab-pane {{ $tab == '' ? 'active' : '' }}">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-data')
                  </div>

                  <div class="tab-pane {{ $tab == 'editar' ? 'active' : '' }}">
                    {{-- @include('livewire.valuacion.ver-valuacion.tabs.tab-editar') --}}
                    @livewire('valuacion.editar-valuacion', ['id' => $valuacion->id])
                  </div>
{{-- 
                  <div class="tab-pane {{ $tab == 'cliente' ? 'active' : '' }}" id="tab_2">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-cliente')
                  </div> --}}

                  <div class="tab-pane {{ $tab == 'fotos' ? 'active' : '' }}">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-fotos')
                  </div>

                  <div class="tab-pane {{ $tab == 'docs' ? 'active' : '' }}">
                      @include('livewire.valuacion.ver-valuacion.tabs.tab-documentos')
                  </div>


              </div>
          </div>
      </div>
  </div>


</div>
