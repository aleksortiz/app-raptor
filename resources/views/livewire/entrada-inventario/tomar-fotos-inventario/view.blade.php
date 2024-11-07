<div class="p-5 mx-5">

    @if ($this->firma)
      <div class="row">
        <div class="col-sm-8">
          <div class="layer">
            <center>
              <h2 class="text-center">Firma: {{$this->entrada->cliente->nombre}}</h2>
              <div wire:ignore>
                <canvas id="drawingCanvas"></canvas>
              </div>
              <br>

              <button wire:click="fotos" class="btn btn-lg btn-warning"><i class="fa fa-camera"></i> Fotos ({{$this->entrada->fotos->count()}})</button>
              <button class="ml-3 btn btn-lg btn-secondary" onclick="cleanCanvas()"><i class="fa fa-eraser"></i> Limpiar Firma</button>
              <button wire:click="guardarFirma" class="ml-3 btn btn-lg btn-success"><i class="fa fa-check"></i> Aceptar</button>


            </center>
          </div>
        </div>

        <div class="col-sm-4">
          @php
            $inv = json_decode($this->inventario->inventario);
            $testigos = json_decode($this->inventario->testigos);
          @endphp
          <h3 class="mt-5 mb-4"><u>Inventario: {{$this->entrada->vehiculo}}</u></h3>
          <h3 class="mb-4">Estereo: {{$inv->estereo}}</h3>
          <h3 class="mb-4">Tapetes: {{$inv->tapetes}}</h3>
          <h3 class="mb-4">Parabrisas: {{$inv->parabrisas}}</h3>
          <h3 class="mb-4">Gato: {{$inv->gato}}</h3>
          <h3 class="mb-4">Extra: {{$inv->extra}}</h3>
          <h3 class="mb-4">Herramientas: {{$inv->herramientas}}</h3>
          <h3 class="mb-4">Cables: {{$inv->cables}}</h3>
        </div>


      </div>
    @else

      <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label style="font-size: 25px;">Cliente</label>
                <h4>{{$this->entrada->cliente->nombre}}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label style="font-size: 25px;">Vehículo</label>
                <h4>{{$this->entrada->vehiculo}}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label style="font-size: 25px;">Folio</label>
                <h4>{{$this->entrada->folio_short}}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label style="font-size: 25px;">Firmar</label><br>
                <button wire:click="firmar" class="btn btn-md btn-primary"><i class="fa fa-marker"></i> FIRMA CLIENTE</button>

            </div>
        </div>
    </div>

      <center class="mt-5">
        @livewire('fotos.subir-fotos', [
          'model' => $this->entrada,
          'storage_path' => 'entradas/fotos'
        ])
      </center>


      <center class="mt-5">
      </center>
    @endif

</div>
