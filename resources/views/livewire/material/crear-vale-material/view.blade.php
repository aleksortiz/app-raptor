@section('title', __('Vale de Materiales'))
<div class="pt-3">

  <div class="row layout-top-spacing">
    <div class="col-12 col-md-8">

      @include('livewire.material.crear-vale-material.partials.tabla-productos')

    </div>
    <div class="col-12 col-md-4">
      <div class="sticky-top">

        <!--TOTAL PANEL -->
        @include('livewire.material.crear-vale-material.partials.card-total')

        <!--CLIENTE-->
        @include('livewire.material.crear-vale-material.partials.card-personal')

        <!--PRODUCTO-->
        {{-- @include('livewire.ventas.pos.partials.productos') --}}

        <!--COMENTARIOS-->
        @include('livewire.material.crear-vale-material.partials.card-comentarios')
      </div>
    </div>

  </div>

  <livewire:personal.common.mdl-select-personal emitAction="setPersonal" />
  <livewire:material.common.select-material validStock={{true}} />
  <livewire:entrada.common.mdl-select-entrada emitAction="setEntrada" />
  @include('livewire.material.crear-vale-material.partials.mdl-material-manual')
</div>



