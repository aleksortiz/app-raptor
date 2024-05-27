<div class="d-inline">
    <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#btnOcDetail{{ $this->orden->id }}">
        <i class='fa fa-shopping-cart'></i> Ver Orden
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="btnOcDetail{{ $this->orden->id }}">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proyecto: #{{ $this->orden->proyecto->id_paddy }}, Orden de Compra:
                        #{{ $this->orden->id_paddy }} {{ $this->orden->nombre }}</h5>
                    <button type="button" class="close" data-toggle="modal"
                        data-target="#btnOcDetail{{ $this->orden->id }}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div class="card card-primary card-outline card-outline-tabs" style="min-height: 500px;">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a wire:click="$set('activeTab',1)"
                                        class="nav-link @if ($this->activeTab == 1) active @endif"
                                        style="cursor: pointer;" role="tab" aria-selected="true">Conceptos de
                                        Compra</a>
                                </li>
                                <li class="nav-item">
                                    <a wire:click="$set('activeTab',2)"
                                        class="nav-link @if ($this->activeTab == 2) active @endif"
                                        style="cursor: pointer;" role="tab" aria-selected="true">Proveedor</a>
                                </li>
                                <li class="nav-item">
                                    <a wire:click="$set('activeTab',3)"
                                        class="nav-link @if ($this->activeTab == 3) active @endif"
                                        style="cursor: pointer;" role="tab" aria-selected="true">Comentarios</a>
                                </li>
                                <li class="nav-item">
                                    <a wire:click="$set('activeTab',4)"
                                        class="nav-link @if ($this->activeTab == 4) active @endif"
                                        style="cursor: pointer;" role="tab" aria-selected="true">Historial de
                                        Estatus</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-0">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="pl-3 tab-pane fade @if ($this->activeTab == 1) show active @endif" id="tab1" role="tabpanel">
                                    @include('livewire.compra.common.btn-compra-detalles.partials.tab-conceptos')
                                </div>

                                <div class="tab-pane fade @if ($this->activeTab == 2) show active @endif"
                                    id="tab2" role="tabpanel">
                                    @include('livewire.compra.common.btn-compra-detalles.partials.tab-proveedor')
                                </div>

                                <div class="tab-pane fade @if ($this->activeTab == 3) show active @endif"
                                    id="tab3" role="tabpanel">
                                    @include('livewire.compra.common.btn-compra-detalles.partials.tab-comentarios')
                                </div>

                                <div class="tab-pane fade @if ($this->activeTab == 4) show active @endif"
                                    id="tab4" role="tabpanel">
                                    @include('livewire.compra.common.btn-compra-detalles.partials.tab-historial')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                        data-target="#btnOcDetail{{ $this->orden->id }}"><i class="fas fa-window-close"></i>
                        Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
