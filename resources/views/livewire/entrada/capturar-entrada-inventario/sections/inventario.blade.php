<div>
  <h1>Inventario:  </h1>
  <div class="row">

    <div class="col">
      <div class="d-flex flex-wrap justify-content-between">
        <div>
          <div class="form-group">
            <label id="lblEstereo" class="text-xl" for="estereo">Estereo</label>
            <select data-label="lblEstereo" wire:model.defer="estereo" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="FUNCIONAL">FUNCIONAL</option>
              <option value="NO TIENE">NO TIENE</option>
              <option value="NO FUNCIONA">NO FUNCIONA</option>
            </select>
            @error('estereo') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblTapetes" class="text-xl" for="tapetes">Tapetes</label>
            <select data-label="lblTapetes" wire:model.defer="tapetes" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="COMPLETOS">COMPLETOS</option>
              <option value="INCOMPLETOS">INCOMPLETOS (Incluir Notas)</option>
              <option value="SIN TAPETES">SIN TAPETES</option>
            </select>
            @error('tapetes') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblParabrisas" class="text-xl" for="parabrisas">Parabrisas</label>
            <select data-label="lblParabrisas" wire:model.defer="parabrisas" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="SIN DETALLES">SIN DETALLES</option>
              <option value="TIENE DETALLE">TIENE DETALLE</option>
            </select>
            @error('parabrisas') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblGato" class="text-xl" for="gato">Gato</label>
            <select data-label="lblGato" wire:model.defer="gato" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE GATO</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('gato') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblExtra" class="text-xl" for="extra">Extra</label>
            <select data-label="lblExtra" wire:model.defer="extra" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE EXTRA</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('extra') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblHerramientas" class="text-xl" for="herramientas">Herramientas</label>
            <select data-label="lblHerramientas" wire:model.defer="herramientas" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE HERRAMIENTAS</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('herramientas') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>

        <div>
          <div class="form-group">
            <label id="lblCables" class="text-xl" for="cables">Cables</label>
            <select data-label="lblCables" wire:model.defer="cables" class="form-control form-control-lg form-select">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE CABLES</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('cables') <span class="text-danger">* Seleccione</span> @enderror
          </div>
        </div>


      </div>
    </div>


  </div>
</div>
