@section('title', __('Reporte de Finanzas'))
<div class="pt-3">
    <div class="row ml-4 mt-2">

        <div class="col-1">
            <div class="form-group">
                <label for="keyWord">Año</label>
                <select wire:model="year" class="form-control" id="year">
                    @foreach (range(2021, $this->maxYear) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label for="keyWord">Semana</label>
                <select wire:model.lazy="weekStart" class="form-control" id="weekStart">
                    @foreach (range(1, 52) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-1">
            <div class="form-group">
                <label for="keyWord">a la</label>
                <select wire:model.lazy="weekEnd" class="form-control" id="weekEnd">
                    @foreach (range(1, 52) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label>Ver Gráfica</label>
                <label class="content-input">
                    <input wire:model="viewGraph" type="checkbox" />
                    <i></i>
                </label>
            </div>
        </div>

    </div>

    @if ($this->viewGraph)

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Gráfica</h4>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chartdiv" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
      <div class="card-header">
          <h3 class="card-title"><b>Informativo de la semana {{$this->weekStart}} a la {{$this->weekEnd}}</b></h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <a style="color: inherit" href="/servicios?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                <div class="info-box" style="cursor: pointer;">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Vehículos Registrados: @qty($this->cantVehiculosRegistrados)</b></span>
                        <span class="text-lg info-box-number">@money($this->totalVehiculosRegistrados)</span>
                    </div>

                </div>
            </a>
          </div>

          <div class="col">
            <a style="color: inherit" href="/vehiculos-entregados?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                <div class="info-box" style="cursor: pointer;">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Vehículos Entregados: @qty($this->cantVehiculosEntregados)</b></span>

                        <span class="text-lg info-box-number">@money($this->totalVehiculosEntregados)</span>
                    </div>
                </div>
            </a>
          </div>

          <div class="col">
            <a style="color: inherit" href="/reporte-facturas?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                <div class="info-box" style="cursor: pointer;">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Pagado:</b></span>
                        <span class="text-lg info-box-number">@money($this->totalPagado)</span>
                    </div>

                </div>
            </a>
          </div>

          <div class="col">

            <a style="color: inherit" href="/reporte-facturas?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                <div class="info-box" style="cursor: pointer;">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Pendiente: </b></span>
                        <span class="text-lg info-box-number">@money($this->totalPagosPendientes)</span>
                    </div>

                </div>
            </a>

          </div>
        </div>

        <div class="row">
          <div class="col">
            <a style="color: inherit" href="/materiales/pedidos?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                <div class="info-box" style="cursor: pointer;">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Pedidos a Proveedor: </b></span>
                        <span class="text-lg info-box-number">@money($this->totalPedidos)</span>
                    </div>

                </div>
            </a>
          </div>

          <div class="col">
            <a style="color: inherit" href="/materiales/bitacora?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
              <div class="info-box" style="cursor: pointer;">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text"><b>Materiales asignados: </b></span>
                      <span class="text-lg info-box-number">@money($this->totalMateriales)</span>
                  </div>

              </div>
            </a>
          </div>

          <div class="col">
            <a style="color: inherit" href="/personal/diagrama-nomina?year={{$this->year}}&week={{$this->weekStart}}" target="_blank" >
              <div class="info-box" style="cursor: pointer;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text"><b>Sueldos Operativos: </b></span>
                      <span class="text-lg info-box-number">@money($this->totalNomina)</span>
                  </div>

              </div>
            </a>
          </div>

          <div class="col">
            <a style="color: inherit" href="/personal/ordenes-trabajo?year={{$this->year}}&week={{$this->weekStart}}&reportePersonal=true" target="_blank" >
              <div class="info-box" style="cursor: pointer;">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><b>Destajos: </b></span>
                    <span class="text-lg info-box-number">@money($this->totalDestajos)</span>
                </div>

              </div>
            </a>
          </div>


        </div>

        <div class="row">
          <div class="col-3">
            <a style="color: inherit" href="/materiales/pedidos?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
              <div class="info-box" style="cursor: pointer;">
                  <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text"><b>Pagos a Proveedor: </b></span>
                      <span class="text-lg info-box-number">@money($this->totalPagosProveedores)</span>
                  </div>

              </div>
            </a>
          </div>
        </div>


      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
              <h3 class="card-title"><b>Gastos: @money($this->totalGastos)</b></h3>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col">
                <div class="info-box" style="cursor: pointer;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text"><b>Sueldos Administrativos: </b></span>
                      <span class="text-lg info-box-number">@money($this->totalSueldosAdministrativos)</span>
                  </div>

                </div>
              </div>



              <div class="col">
                <a style="color: inherit" href="/gastos-fijos?year={{$this->year}}&week={{$this->weekStart}}" target="_blank" >
                  <div class="info-box" style="cursor: pointer;">
                      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                          <span class="info-box-text"><b>Gastos Fijos: </b></span>
                          <span class="text-lg info-box-number">@money($this->totalGastosFijos)</span>
                      </div>

                  </div>
                </a>
              </div>

              <div class="col">
                <a style="color: inherit" href="/gastos-fijos?year={{$this->year}}&week={{$this->weekStart}}" target="_blank" >
                  <div class="info-box" style="cursor: pointer;">
                      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                          <span class="info-box-text"><b>Gastos Generales: </b></span>
                          <span class="text-lg info-box-number">@money($this->totalGastosGenerales)</span>
                      </div>

                  </div>
                </a>
              </div>


            </div>








          </div>
        </div>
      </div>
    </div>




    <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Resultados</b></h3>
            </div>
            <div class="card-body">

                {{-- <a style="color: inherit" href="/reporte-facturas?keyWord=&year={{$this->year}}&weekStart={{$this->weekStart}}&weekEnd={{$this->weekEnd}}" target="_blank" >
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pagos Realizados:</b></span>
                            <span class="text-lg info-box-number">@money($this->totalPagosRealizados)</span>
                        </div>
                    </div>
                </a> --}}

                {{-- <h3>Totales:</h3> --}}
                <div class="row">
                  <div class="col-4">
                    <div class="info-box" style="cursor: pointer;">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                      <div class="info-box-content">
                          <span class="info-box-text"><b>Utilidad antes de gastos: </b></span>
                          <span class="text-lg info-box-number">@money($this->utilidadBruta)</span>
                      </div>

                    </div>
                  </div>

                  <div class="col-4">
                    <div class="info-box" style="cursor: pointer;">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text"><b>Utilidad Neta: (@qty($this->porcUtilidadNeta)% de @money($this->totalVehiculosEntregados))</b></span>
                          <span class="text-lg info-box-number">@money($this->utilidadNeta)</span>
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    @if ($this->qty_semanas > 1)
                      <div class="info-box" style="cursor: pointer;">
                          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                          <div class="info-box-content">
                              <span class="info-box-text"><b>Utilidad Neta Promedio en @qty($this->qty_semanas) Semanas</b></span>
                              <span class="text-lg info-box-number">@money($this->utilidadNeta / $this->qty_semanas)</span>
                          </div>
                      </div>

                    @endif
                  </div>


                </div>






            </div>
          </div>
        </div>
    </div>




</div>
