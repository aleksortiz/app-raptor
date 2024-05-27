@section('title', __("Monitor de Compras"))

<div class="row mt-3">
    <div class="col">
        {{-- <div class="p-2 mt-0">
            <a href="/compras/crear-orden-compra">Crear Orden de Compra</a>
        </div> --}}

        <div class="card card-primary card-outline card-outline-tabs" style="min-height: 500px;">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a wire:click="$set('activeTab',1)" class="nav-link @if ($this->activeTab == 1) active @endif" style="cursor: pointer;" role="tab" aria-selected="true">Pendientes de Autorizar</a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="$set('activeTab',2)" class="nav-link @if ($this->activeTab == 2) active @endif" style="cursor: pointer;" role="tab" aria-selected="true">Ordenes Autorizadas</a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="$set('activeTab',3)" class="nav-link @if ($this->activeTab == 3) active @endif" style="cursor: pointer;" role="tab" aria-selected="true">Ordenes Enviadas</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a wire:click="$set('activeTab',4)" class="nav-link @if ($this->activeTab == 4) active @endif" style="cursor: pointer;" role="tab" aria-selected="true">Ordenes de Compra</a>
                    </li> --}}
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                
                    <div class="tab-pane fade @if ($this->activeTab == 1) show active @endif" id="tab1" role="tabpanel">
                        <livewire:compra.common.ordenes-pendientes />
                    </div>

                    <div class="tab-pane fade @if ($this->activeTab == 2) show active @endif" id="tab2" role="tabpanel">
                        <livewire:compra.common.ordenes-autorizadas />
                    </div>

                    <div class="tab-pane fade @if ($this->activeTab == 3) show active @endif" id="tab3" role="tabpanel">
                        <livewire:compra.common.ordenes-enviadas />
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>