<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateCosto">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Concepto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label>Tipo</label>
                      <select wire:model="costo.tipo" class="form-control">
                          <option value="">--Seleccione--</option>
                          <option value="SERVICIO">SERVICIO GENERICO</option>
                          <option value="MANO DE OBRA">MANO DE OBRA</option>
                          <option value="REFACCION">REFACCION</option>
                          <option value="PARTE">PARTE</option>
                          <option value="OTRO TALLER">OTRO TALLER</option>
                      </select>

                      @error('costo.tipo')
                          <span class="error text-danger">Seleccione tipo</span>
                      @enderror
                  </div>
                </div>

                <div class="col">

                  @php
                      $placeholder = '';
                      if ($this->costo?->tipo == 'SERVICIO') {
                          $placeholder = 'Ejemplo: Cambio de Aceite';
                      }
                      if ($this->costo?->tipo == 'MANO DE OBRA') {
                          $placeholder = 'Ejemplo: Pintura y carroceria';
                      }
                      if ($this->costo?->tipo == 'REFACCION') {
                          $placeholder = 'Ejemplo: Defensa Delantera';
                      }
                      if ($this->costo?->tipo == 'PARTE') {
                          $placeholder = 'Ejemplo: Filtro de Aceite';
                      }
                      if ($this->costo?->tipo == 'OTRO TALLER') {
                          $placeholder = 'Ejemplo: Reparación de Transmisión';
                      }
                  @endphp

                  <div class="form-group">
                      <label>Concepto</label>
                      <input placeholder="{{$placeholder}}" wire:model.defer="costo.concepto" type="text" class="form-control" />
                      @error('costo.concepto')
                          <span class="error text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                </div>
              </div>




              @if ($this->costo?->tipo == 'SERVICIO')
                <div class="row">

                  <div class="col-3">
                    <div class="form-group">
                        <label>Precio del Servicio</label>
                        <input style="text-align: right;" wire:model="costo.venta" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.venta')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                </div>
              @endif

              @if ($this->costo?->tipo == 'MANO DE OBRA')
                <div class="row">

                  <div class="col-3">
                    <div class="form-group">
                        <label>Mano de Obra</label>
                        <input style="text-align: right;" wire:model="costo.venta" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.venta')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group">
                        <label>Presupuesto para Destajos ({{$this->porcentaje_mo}}%)</label>
                        <H4>@money($this->presupuesto_destajos)</H4>
                    </div>
                  </div>


                </div>
              @endif

              @if ($this->costo?->tipo == 'REFACCION')
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto me cuesta la refacción?</label>
                        <input style="text-align: right;" wire:model="costo.costo" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.costo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto vendo la refacción?</label>
                        <input style="text-align: right;" wire:model="costo.venta" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.venta')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                </div>
              @endif

              @if ($this->costo?->tipo == 'PARTE')
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto me cuesta?</label>
                        <input style="text-align: right;" wire:model="costo.costo" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.costo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto la vendo?</label>
                        <input style="text-align: right;" wire:model="costo.venta" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.venta')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                </div>
              @endif

              @if ($this->costo?->tipo == 'OTRO TALLER')
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto me cobra el otro taller?</label>
                        <input style="text-align: right;" wire:model="costo.costo" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.costo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                        <label>¿Cuanto le cobro al cliente?</label>
                        <input style="text-align: right;" wire:model="costo.venta" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57"/>
                        @error('costo.venta')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                </div>
              @endif





            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="saveCosto" class="btn btn-primary"><i
                    class="fas fa-plus"></i> Agregar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
