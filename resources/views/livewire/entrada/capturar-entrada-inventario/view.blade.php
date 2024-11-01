@section('title', __('Generar Entrada'))

<div>
    <div class="row">


        @if ($this->firmar)

          <div class="col-sm-12">
              <h4>Firma de Cliente</h4>
              <div>
                  <div class="layer">
                      <center>
                        <div wire:ignore>

                          <canvas id="drawingCanvas"></canvas>
                        </div>
                          <br>
                          <button class="btn btn-secondary" wire:click="toggle"><i class="fa fa-arrow-left"></i> Regresar</button>
                          <button class="btn btn-success" wire:click="aceptar"><i class="fa fa-check"></i> Aceptar</button>

                      </center>
                  </div>
              </div>
          </div>

        @else
          <div class="col-sm-12">
            <h4>Inventario:  </h4>

            <div class="form-group">
                <label>Descripción</label>
                <textarea placeholder="Descripción del inventario" class="form-control" wire:model.defer="entrada.inventario" rows="4"></textarea>
                @error('entrada.inventario') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" wire:model.defer="entrada.color" class="form-control" placeholder="Color">
                        @error('entrada.color') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Placas</label>
                        <input type="text" wire:model.defer="entrada.placas" class="form-control" placeholder="Color">
                        @error('entrada.placas') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Año</label>
                        <input type="text" wire:model.defer="entrada.year" class="form-control" maxlength="4" placeholder="Año">
                        @error('entrada.year') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Kilometraje</label>
                        <input type="text" wire:model.defer="entrada.kilometraje" class="form-control" placeholder="Kilometraje" onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                        @error('entrada.kilometraje') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Gasolina: {{$this->entrada->gasolina}}%</label>
                        <div wire:ignore>
                            <input id="range_gas" type="text" name="range_gas" value>
                        </div>
                        @error('entrada.gasolina') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col">
                <button class="btn btn-success" wire:click="toggle"><i class="fa fa-check"></i> Terminar</button>
                <button class="btn btn-success" wire:click="slider"><i class="fa fa-check"></i> SKUDER</button>
              </div>
            </div>

          </div>
        @endif

    </div>
</div>


