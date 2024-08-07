@section('title', __('Reporte de Finanzas'))
<div class="pt-3">
    <div style="min-height: 85vh" class="card">
        <div class="card-header">
            <h3 class="card-title">Reporte de Finanzas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        {{-- <div class="card-body ">

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

            </div>

            <div class="row">

            </div>

            <div class="row">

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Vehículos Registrados: @qty($this->cantVehiculosRegistrados)</b></span>
                            <span class="text-lg info-box-number">@money($this->totalVehiculosRegistrados)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Vehículos Entregados:</b></span>
                            <span class="text-lg info-box-number">@qty($this->cantVehiculosEntregados)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pedidos a Proveedor: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalPedidos)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Materiales asignados: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalMateriales)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Sueldos: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalSueldos)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Gastos Fijos: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalGastosFijos)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pagos Realizados:</b></span>
                            <span class="text-lg info-box-number">@money($this->totalPagosRealizados)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pagos Pendientes: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalPagosPendientes)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-dollar-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Utilidad Virtual: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalUtilidadVirtual)</span>
                        </div>

                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box" wire:click="mdlMaterialesDetalle" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Utilidad Real: </b></span>
                            <span class="text-lg info-box-number">@money($this->totalUtilidadReal)</span>
                        </div>

                    </div>
                </div>


            </div>

        </div> --}}

        <div class="card-body">

        </div>
    </div>
</div>
