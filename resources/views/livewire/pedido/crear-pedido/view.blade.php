@section('title', __('Pedidos'))
<div class="pt-3">

  <div class="row layout-top-spacing">
    <div class="col-12 col-md-8">

      @include('livewire.pedido.crear-pedido.partials.tabla-productos')

    </div>
    <div class="col-12 col-md-4">
      <div class="sticky-top">
        
        <!--TOTAL PANEL -->
        @include('livewire.pedido.crear-pedido.partials.card-total')

        <!--CLIENTE-->
        @include('livewire.pedido.crear-pedido.partials.card-proveedor')

        <!--PRODUCTO-->
        {{-- @include('livewire.ventas.pos.partials.productos') --}}

        <!--COMENTARIOS-->
        @include('livewire.pedido.crear-pedido.partials.card-comentarios')
      </div>
    </div>      
    
  </div>
    
  @if ($this->pedido_t->proveedor)
    @include('livewire.pedido.crear-pedido.partials.mdl-enviar-pedido')
  @endif

  <livewire:proveedor.common.mdl-select-proveedor emitAction="setProveedor" />
  <livewire:material.common.select-material validStock={{false}} />
  @include('livewire.pedido.crear-pedido.partials.mdl-material-manual')

  {{-- <livewire:producto.common.mdl-select-producto emitAction="addProducto" priceField='costo' checkStock={{false}} /> --}}
  {{-- <livewire:producto.common.mdl-select-qty emitAction="changeQty" /> --}}
</div>



