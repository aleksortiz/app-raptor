<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h5 class="pl-3 pt-3">{{ $proveedor->nombre }}</h5>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-user-tie"></i> Datos Generales</a></li>
                    {{-- <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-users"></i> Contactos</a></li> --}}
                </ul>
            </div>
            
            <div class="card-body p-0">
                <div class="tab-content">
                    @include('livewire.proveedor.edit-proveedor.tabs.tab-datos-generales')

                    {{-- @include('livewire.proveedor.edit-proveedor.tabs.tab-contactos') --}}
                </div>
            </div>
        </div>
    </div>

</div>