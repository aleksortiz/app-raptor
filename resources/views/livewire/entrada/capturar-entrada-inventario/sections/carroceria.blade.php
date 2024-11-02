<div class="mt-4">

  <style>
    .checkB {
      width: 40px;
      height: 40px;
    }

    .checkB-2 {
      width: 30px;
      height: 30px;
    }
  </style>

  <div class="row mt-4">
    <div class="col">
      <h1>Carroceria:</h1>
      <div>
        <div class="d-flex align-items-center mt-5">
          <label id="lblPuertas" style="font-size: 35px;" for="puertas">Puertas</label>
          <input type="checkbox" data-target="#selectPuertas" wire:model.defer="puertas" class="ml-3 checkB">
        </div>

        <div class="d-flex align-item-center mt-2">
          <div id="selectPuertas" class="d-none mt-3" style="margin-left: 10px;">
            <label style="font-size: 35px;" for="puertas_1">1</label>
            <input type="checkbox" id="puertas_1" wire:model.defer="puertas_1" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="puertas_derecha">2</label>
            <input type="checkbox" id="puertas_2" wire:model.defer="puertas_2" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="puertas_3">3</label>
            <input type="checkbox" id="puertas_3" wire:model.defer="puertas_3" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="puertas_4">4</label>
            <input type="checkbox" id="puertas_4" wire:model.defer="puertas_4" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="puertas_5">5</label>
            <input type="checkbox" id="puertas_5" wire:model.defer="puertas_5" class="ml-4 checkB-2">
          </div>

        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblCostados" style="font-size: 35px;" for="costados">Costados</label>
          <input type="checkbox" data-target="#selectCostados" wire:model.defer="costados" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div id="selectCostados" class="d-none" style="margin-left: 20px;">
            <label style="font-size: 35px;" for="costados_izquierdo">Izquierdo</label>
            <input type="checkbox" id="costados_izquierdo" wire:model.defer="costados_izquierdo" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="costados_derecho">Derecho</label>
            <input type="checkbox" id="costados_derecho" wire:model.defer="costados_derecho" class="ml-4 checkB-2">
          </div>
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblPisoCajuela" style="font-size: 35px;" for="piso_cajuela">Piso Cajuela</label>
          <input type="checkbox" wire:model.defer="piso_cajuela" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblTolvaEscape" style="font-size: 35px;" for="tolva_escape">Tolva Escape</label>
          <input type="checkbox" wire:model.defer="tolva_escape" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblCapacete" style="font-size: 35px;" for="capacete">Capacete</label>
          <input type="checkbox" wire:model.defer="capacete" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblCofre" style="font-size: 35px;" for="cofre">Cofre</label>
          <input type="checkbox" wire:model.defer="cofre" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblRepGranizo" style="font-size: 35px;" for="rep_granizo">Rep Granizo</label>
          <input type="checkbox" wire:model.defer="rep_granizo" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblPinturaGeneral" style="font-size: 35px;" for="pintura_general">Pintura General</label>
          <input type="checkbox" wire:model.defer="pintura_general" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblFender" style="font-size: 35px;" for="fender">Fender</label>
          <input data-target="#selectFender" type="checkbox" wire:model.defer="fender" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div id="selectFender" class="d-none" style="margin-left: 20px;">
            <label style="font-size: 35px;" for="fender_izquierdo">Izquierdo</label>
            <input type="checkbox" id="fender_izquierdo" wire:model.defer="fender_izquierdo" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="fender_derecho">Derecho</label>
            <input type="checkbox" id="fender_derecho" wire:model.defer="fender_derecho" class="ml-4 checkB-2">
          </div>
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblFacia" style="font-size: 35px;" for="facia">Facia</label>
          <input data-target="#selectFacia" type="checkbox" wire:model.defer="facia" class="ml-3 checkB">

        </div>

        <div class="d-flex align-items-center mt-2">
          <div id="selectFacia" class="d-none" style="margin-left: 20px;">
            <label style="font-size: 35px;" for="facia_izquierda">Izquierda</label>
            <input type="checkbox" id="facia_izquierda" wire:model.defer="facia_izquierda" class="ml-4 checkB-2">

            <label class="ml-4" style="font-size: 35px;" for="facia_derecha">Derecha</label>
            <input type="checkbox" id="facia_derecha" wire:model.defer="facia_derecha" class="ml-4 checkB-2">
          </div>
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblCarroceriaOtro" style="font-size: 35px;" for="carroceria_otro">Otro</label>
          <input data-target="#carroceria_otro_section" type="checkbox" wire:model.defer="carroceria_otro" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div class="d-none" id="carroceria_otro_section">
            <input type="text" style="width: 500px;" wire:model.defer="carroceria_otro_text" class="form-control form-control-lg" placeholder="Especificar">
          </div>
        </div>

      </div>
    </div>

    <div class="col">
      <h1>Mecanica:</h1>
      <div>
        <div class="d-flex align-items-center">
          <label id="lblAfinacionMayor" style="font-size: 35px;" for="afinacion_mayor">Afinación Mayor</label>
          <input type="checkbox" wire:model.defer="afinacion_mayor" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblCambioAceite" style="font-size: 35px;" for="cambio_aceite">Cambio de Aceite</label>
          <input type="checkbox" wire:model.defer="cambio_aceite" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblFallaMecanica" style="font-size: 35px;" for="falla_mecanica">Falla Mecánica</label>
          <input data-target="#falla_mecanica_section" type="checkbox" wire:model.defer="falla_mecanica" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div class="d-none" id="falla_mecanica_section">
            <input style="width: 500px;" type="text" wire:model.defer="falla_mecanica_text" class="form-control form-control-lg" placeholder="Especificar">
          </div>
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblFrenos" style="font-size: 35px;" for="frenos">Frenos</label>
          <input type="checkbox" wire:model.defer="frenos" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblSuspension" style="font-size: 35px;" for="suspension">Suspensión</label>
          <input data-target="#suspension_section" type="checkbox" wire:model.defer="suspension" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div class="d-none" id="suspension_section">
            <input style="width: 500px;" type="text" wire:model.defer="suspension_text" class="form-control form-control-lg" placeholder="Especificar">
          </div>
        </div>

        <div class="d-flex align-items-center mt-5">
          <label id="lblMecanicaOtro" style="font-size: 35px;" for="mecanica_otro">Otro</label>
          <input data-target="#mecanica_otro_text_section" type="checkbox" wire:model.defer="mecanica_otro" class="ml-3 checkB">
        </div>

        <div class="d-flex align-items-center mt-2">
          <div class="d-none" id="mecanica_otro_text_section">
            <input style="width: 500px;" type="text" wire:model.defer="mecanica_otro_text" class="form-control form-control-lg" placeholder="Especificar">
          </div>
        </div>


      </div>
    </div>
  </div>



</div>
