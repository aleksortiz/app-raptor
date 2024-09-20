<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-cash-register"></i> Total de Pedido</h3>

    <div class="card-tools">
      <button class="btn btn-xs btn-danger" wire:click="limpiar"><i class="fas fa-broom"></i> Limpiar Pedido</button>
    </div>
  </div>

  <div class="card-body">
    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h4>Materiales</h4>
      </div>
      <div class="col-12 col-md-6">
        <h4>@qty($this->count_materiales)</h4>
      </div>
    </div>

    <hr>

    {{-- <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Total</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@money(222222)</h3><p class="m-0" style="font-size: 15px;">
      </div>
    </div> --}}


    @if (collect($this->listadoMaterial)->count() > 0 && $this->personal?->id)
      <hr>
      <div class="row layout-top-spacing">
        <div class="col-12">
          <button onclick="confirm('¿Desea crear vale de material?', 'crearVale')" class="btn btn-large btn-block btn-success"><i class="fa fa-ticket-alt"></i> CREAR VALE</button>
        </div>
      </div>
    @endif



  </div>

</div>
