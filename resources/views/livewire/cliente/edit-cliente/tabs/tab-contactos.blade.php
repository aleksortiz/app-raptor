<div class="tab-pane {{ $activeTab == 2 ? 'active' : '' }}" id="tab_2">
    <div class="card m-0" style="min-height: 65vh;">
        <div class="card-body">
            @livewire('contacto.catalogo-contactos', ['morphsModel' => $cliente])    
        </div>
    </div>
</div>
