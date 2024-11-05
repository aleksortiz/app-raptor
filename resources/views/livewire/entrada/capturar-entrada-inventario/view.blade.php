@section('title', __('Generar Entrada'))

<div>
    <div class="row" style="margin-left: 5%; margin-right: 5%;">


      <div class="col-sm-12 p-5">

        <div class="row">
            <div class="col-5">
                <div class="form-group">
                    <label style="font-size: 25px;">Cliente</label>
                    <h4>{{$this->cita->cliente->nombre}}</h4>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label style="font-size: 25px;">Vehículo</label>
                    <h4>{{$this->cita->vehiculo}}</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label style="font-size: 25px;">Teléfono</label>
                    <h4>{{$this->cita->cliente->telefono}}</h4>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-3">
                <div class="form-group">
                    <label style="font-size: 25px;">Año</label>
                    <input type="text" wire:model.defer="year" class="form-control form-control-lg" maxlength="4" placeholder="Año" onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label style="font-size: 25px;">Kilometraje</label>
                    <input type="text" wire:model.defer="kilometros" class="form-control form-control-lg" placeholder="Kilometraje" onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                    @error('kilometros') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-3">
              <div class="form-group">
                  <label style="font-size: 25px;">Color</label>
                  <input type="text" style="text-transform: uppercase;" wire:model.defer="color" class="form-control form-control-lg" placeholder="Color">
                  @error('color') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
          </div>

          <div class="col-3">
              <div class="form-group">
                  <label style="font-size: 25px;">Placas</label>
                  <input type="text" style="text-transform: uppercase;" wire:model.defer="placas" class="form-control form-control-lg" placeholder="Placas">
                  @error('placas') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
          </div>



        </div>



        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label style="font-size: 25px;">Gasolina: {{$this->gasolina}}%</label>
                    <div wire:ignore>
                        <input id="range_gas" type="text" name="range_gas" value>
                    </div>
                    @error('gasolina') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        @include('livewire.entrada.capturar-entrada-inventario.sections.diagrama')

        @include('livewire.entrada.capturar-entrada-inventario.sections.inventario')
        @include('livewire.entrada.capturar-entrada-inventario.sections.testigos')
        @include('livewire.entrada.capturar-entrada-inventario.sections.carroceria')






        <div class="row mt-5">
          <div class="col">
            <div class="form-group">
                <label style="font-size: 25px;">Notas</label>
                <textarea placeholder="Notas del inventario" class="form-control form-control-lg" wire:model.defer="notas" rows="4"></textarea>
                @error('notas') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>


        <div class="mt-5 row">
          <div class="col">
            <button class="btn btn-block btn-success btn-lg" wire:click="aceptar">TERMINAR <i class="fa fa-check"></i></button>
          </div>
        </div>

      </div>

    </div>
</div>


