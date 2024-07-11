<div class="pt-2">

    @if ($this->selectedUnidad)
        @include('livewire.flotilla.catalogo-flotillas.partials.card-unidad')
    @else
        @include('livewire.flotilla.catalogo-flotillas.partials.card-flotilla')
    @endif

    @include('livewire.flotilla.catalogo-flotillas.modal-flotilla')
    @include('livewire.flotilla.catalogo-flotillas.modal-unidad')

</div>
