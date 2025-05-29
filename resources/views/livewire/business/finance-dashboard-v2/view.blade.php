<div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Dashboard Financiero V2</h3>
                        <div class="d-flex gap-2">
                            <select wire:model="year" class="form-control form-control-sm" style="width: 100px;">
                                @for($i = $maxYear; $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select wire:model="week" class="form-control form-control-sm" style="width: 100px;">
                                @for($i = 1; $i <= 52; $i++)
                                    <option value="{{ $i }}">Semana {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Vehículos Stats -->
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-car"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vehículos Registrados</span>
                                    <span class="info-box-number">{{ $this->vehiculos_registrados->count }}</span>
                                    <span class="info-box-text">${{ number_format($this->vehiculos_registrados->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-tools"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vehículos Terminados</span>
                                    <span class="info-box-number">{{ $this->vehiculos_terminados->count }}</span>
                                    <span class="info-box-text">${{ number_format($this->vehiculos_terminados->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vehículos Entregados</span>
                                    <span class="info-box-number">{{ $this->vehiculos_entregados->count }}</span>
                                    <span class="info-box-text">${{ number_format($this->vehiculos_entregados->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Costos y Gastos -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Costos y Gastos</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Materiales</td>
                                            <td class="text-right">${{ number_format($this->total_materiales, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nómina Taller</td>
                                            <td class="text-right">${{ number_format($this->total_nomina, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nómina Administrativa</td>
                                            <td class="text-right">${{ number_format($this->total_nomina_administrativa, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Destajos</td>
                                            <td class="text-right">${{ number_format($this->total_destajos, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gastos Fijos</td>
                                            <td class="text-right">${{ number_format($this->total_gastos_fijos, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gastos Generales</td>
                                            <td class="text-right">${{ number_format($this->total_gastos_generales, 2) }}</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>Total Gastos</strong></td>
                                            <td class="text-right"><strong>${{ number_format($this->total_gastos, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Utilidad -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Utilidad</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Utilidad Bruta</td>
                                            <td class="text-right">${{ number_format($this->utilidad_bruta, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Gastos</td>
                                            <td class="text-right">-${{ number_format($this->total_gastos, 2) }}</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td><strong>Utilidad Neta</strong></td>
                                            <td class="text-right"><strong>${{ number_format($this->utilidad_neta, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>% Utilidad Neta</td>
                                            <td class="text-right">{{ number_format($this->porc_utilidad_neta, 2) }}%</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Proveedores -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Proveedores</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Total Pedidos</td>
                                            <td class="text-right">${{ number_format($this->total_pedidos, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pagos Realizados</td>
                                            <td class="text-right">${{ number_format($this->total_pagos_proveedores, 2) }}</td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td><strong>Pendiente por Pagar</strong></td>
                                            <td class="text-right"><strong>${{ number_format($this->total_pendiente_proveedores, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 