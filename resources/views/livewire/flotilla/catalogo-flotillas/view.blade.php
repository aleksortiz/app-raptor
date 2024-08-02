<div class="pt-2">

    @if ($this->selectedUnidad)
        @include('livewire.flotilla.catalogo-flotillas.partials.card-unidad')
    @else
        @include('livewire.flotilla.catalogo-flotillas.partials.card-flotilla')
    @endif

    @include('livewire.flotilla.catalogo-flotillas.modals.modal-flotilla')
    @include('livewire.flotilla.catalogo-flotillas.modals.modal-unidad')
    @include('livewire.flotilla.catalogo-flotillas.modals.modal-servicio')
    @include('livewire.flotilla.catalogo-flotillas.modals.modal-update-servicio')
    @include('livewire.flotilla.catalogo-flotillas.modals.modal-fotos-servicio')

</div>
