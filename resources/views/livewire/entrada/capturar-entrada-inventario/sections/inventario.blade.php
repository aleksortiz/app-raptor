<div class="mt-5 card shadow-sm">
  <div class="card-header bg-primary text-white">
    <h4 class="mb-0">
      <i class="fas fa-clipboard-list me-2"></i>
      Inventario del Vehículo
    </h4>
  </div>
  
  <div class="card-body p-4">
    <!-- Sección: Componentes Electrónicos y Accesorios -->
    <div class="mb-4">
      <h5 class="text-muted mb-3 border-bottom pb-2">
        <i class="fas fa-car-battery me-2"></i>
        Componentes Electrónicos y A/C
      </h5>
      <div class="row g-3">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblEstereo" class="form-label fw-semibold text-dark" for="estereo">
              <i class="fas fa-music me-1 text-primary"></i>
              Estéreo
            </label>
            <select data-label="lblEstereo" wire:model.defer="estereo" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="FUNCIONAL">FUNCIONAL</option>
              <option value="NO TIENE">NO TIENE</option>
              <option value="NO FUNCIONA">NO FUNCIONA</option>
            </select>
            @error('estereo') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblAc" class="form-label fw-semibold text-dark" for="ac">
              <i class="fas fa-snowflake me-1 text-info"></i>
              Aire Acondicionado
            </label>
            <select data-label="lblAc" wire:model.defer="ac" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="FUNCIONAL">FUNCIONAL</option>
              <option value="SIN GAS">SIN GAS</option>
              <option value="NO FUNCIONA">NO FUNCIONA</option>
            </select>
            @error('ac') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblParabrisas" class="form-label fw-semibold text-dark" for="parabrisas">
              <i class="fas fa-window-maximize me-1 text-secondary"></i>
              Parabrisas
            </label>
            <select data-label="lblParabrisas" wire:model.defer="parabrisas" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="SIN DETALLES">SIN DETALLES</option>
              <option value="TIENE DETALLE">TIENE DETALLE</option>
            </select>
            @error('parabrisas') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblCables" class="form-label fw-semibold text-dark" for="cables">
              <i class="fas fa-plug me-1 text-warning"></i>
              Cables
            </label>
            <select data-label="lblCables" wire:model.defer="cables" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE CABLES</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('cables') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Sección: Accesorios y Herramientas -->
    <div class="mb-4">
      <h5 class="text-muted mb-3 border-bottom pb-2">
        <i class="fas fa-tools me-2"></i>
        Accesorios y Herramientas
      </h5>
      <div class="row g-3">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblTapetes" class="form-label fw-semibold text-dark" for="tapetes">
              <i class="fas fa-th-large me-1 text-success"></i>
              Tapetes
            </label>
            <select data-label="lblTapetes" wire:model.defer="tapetes" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="COMPLETOS">COMPLETOS</option>
              <option value="INCOMPLETOS">INCOMPLETOS (Incluir Notas)</option>
              <option value="SIN TAPETES">SIN TAPETES</option>
            </select>
            @error('tapetes') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblGato" class="form-label fw-semibold text-dark" for="gato">
              <i class="fas fa-cog me-1 text-danger"></i>
              Gato
            </label>
            <select data-label="lblGato" wire:model.defer="gato" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE GATO</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('gato') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblHerramientas" class="form-label fw-semibold text-dark" for="herramientas">
              <i class="fas fa-toolbox me-1 text-dark"></i>
              Herramientas
            </label>
            <select data-label="lblHerramientas" wire:model.defer="herramientas" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE HERRAMIENTAS</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('herramientas') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label id="lblExtra" class="form-label fw-semibold text-dark" for="extra">
              <i class="fas fa-plus-circle me-1 text-info"></i>
              Extras
            </label>
            <select data-label="lblExtra" wire:model.defer="extra" class="form-control form-control-lg">
              <option value="">--SELECCIONE--</option>
              <option value="TIENE">TIENE EXTRA</option>
              <option value="NO TIENE">NO TIENE</option>
            </select>
            @error('extra') <span class="text-danger small">* Seleccione una opción</span> @enderror
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
