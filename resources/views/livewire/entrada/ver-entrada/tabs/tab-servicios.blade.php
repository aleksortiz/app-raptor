<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">

        <div class="row">

            <div class="col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-car"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Entrada</b></span>
                        <span class="info-box-number">@money($this->entrada->total)</span>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box" wire:click="$set('activeTab', 5)" style="cursor: pointer;">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-wrench"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Refacciones</b></span>
                        <span class="info-box-number">@money($this->entrada->total_costo_refacciones)</span>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box" wire:click="$set('activeTab', 5)" style="cursor: pointer;">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Utilidad Refacciones</b></span>
                        <span class="info-box-number">@money($this->entrada->total_utilidad_refacciones)</span>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box" wire:click="$set('activeTab', 6)" style="cursor: pointer;">
                    <span class="info-box-icon bg-red elevation-1"><i class="fas fa-cubes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Materiales</b></span>
                        <span class="info-box-number">@money($this->entrada->total_materiales)</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-3">
                <div class="info-box" wire:click="$set('activeTab', 7)" style="cursor: pointer;">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Sueldos</b></span>
                        <span class="info-box-number">@money($this->entrada->total_sueldos)</span>
                    </div>

                </div>
            </div>


            <div class="col-sm-3">
                <div class="info-box" wire:click="$set('activeTab', 8)" style="cursor: pointer;">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Destajos</b></span>
                        <span class="info-box-number">@money($this->entrada->total_destajos)</span>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Total Pagado</b></span>
                        <span class="info-box-number">@money($this->entrada->total_costos_pagados)</span>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><b>Utilidad</b></span>
                        <span class="info-box-number">@money($this->entrada->total_utilidad_global) (@float($this->entrada->porcentaje_utilidad_global)%)</span>
                    </div>

                </div>
            </div>



        </div>

        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between">

                    <h5><b>Servicios: </b> @money($this->entrada->total_costos)</h5>
                    <a href="/servicios/{{$this->entrada->id}}/pdf" target="_blank" class="btn btn-xs btn-secondary mb-2"><i class="fa fa-file-pdf"></i> Generar PDF</a>
                </div>

                <table class="table table-hover projects">
                    <thead>
                        <tr>
                            <th><button wire:click="addCosto" class="btn btn-xs btn-success"><i class="fa fa-plus"></i>
                                Agregar Servicio</button></th>
                            <th>Concepto</th>
                            <th>Tipo</th>
                            <th>Costo</th>
                            <th>($) Venta</th>
                            <th>Estatus Pago</th>
                            <th>No. Factura</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrada->costos as $item)
                            @php
                                $editMode = $this->costo && $this->costo->id == $item->id;
                            @endphp
                            <tr>
                                <td>
                                    @if ($editMode)
                                        <button wire:click="saveCosto" class="btn btn-xs btn-success"><i
                                                class="fa fa-save"></i></button>
                                    @else
                                        <button wire:click="" onclick="destroy({{ $item->id }},'Costo', 'destroyCosto')" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                                    @endif
                                </td>

                                <td>
                                    @if ($editMode)
                                        <input wire:model="costo.concepto" type="text"
                                            class="form-control form-control-sm" />
                                        @error('costo.concepto')
                                            <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            @else
                                                {{ $item->concepto }}
                                    @endif
                                </td>

                                <td>
                                    @if ($editMode)
                                        <select wire:model="costo.tipo" class="form-control form-control-sm">
                                            <option value="SERVICIO">SERVICIO</option>
                                            <option value="MANO DE OBRA">MANO DE OBRA</option>
                                            <option value="REFACCION">REFACCION</option>
                                            <option value="OTRO TALLER">OTRO TALLER</option>
                                        </select>
                                        @error('costo.tipo')<span class="error text-danger">{{ $message }}<span>@enderror
                                    @else
                                        {{ $item->tipo }}
                                    @endif
                                </td>

                                <td>
                                  @if (($this->costo && ($this->costo->tipo != 'SERVICIO' && $this->costo->tipo != 'MANO DE OBRA')) || (!$this->costo && ($item->tipo != 'SERVICIO' && $item->tipo != 'MANO DE OBRA')))
                                    @if ($editMode)
                                      <input wire:model="costo.costo" type="text" class="form-control form-control-sm" />
                                      @error('costo.costo')<span class="error text-danger">{{ $message }}<span>@enderror
                                    @else
                                      @money($item->costo)
                                    @endif
                                  @else
                                    N/A
                                  @endif

                                </td>


                                <td>
                                    @if ($editMode)
                                        <input wire:model="costo.venta" type="text"
                                            class="form-control form-control-sm"
                                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                                        @error('costo.venta')
                                            <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            @else
                                                @money($item->venta)
                                    @endif
                                </td>
                                <td>
                                    @if ($item->pagado)
                                        @if ($editMode)

                                        <div class="row">
                                            <div class="col">
                                                <input style="display: inline-block;" wire:model="costo.pagado" type="datetime-local"
                                                class="form-control form-control-sm" />
                                                @error('costo.pagado')
                                                    <span class="error text-danger">{{ $message }}<span>
                                                @enderror
                                            </div>
                                            <div class="col-2">
                                                <button style="display: inline-block;" wire:click="eliminarPagoServicio({{ $item->id }})" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>



                                        @else
                                            <i style="color: green;" class="fa fa-check"></i> Pagado:
                                            {{ $item->fecha_pago_format }}
                                        @endif
                                    @else
                                        @if ($editMode)
                                            N/A
                                        @else
                                            <button wire:click="pagarServicio({{ $item->id }})"
                                                class="btn btn-xs btn-secondary"><i class="fa fa-clock"></i> Pago
                                                Pendiente</button>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($editMode)
                                        <input style="text-transform: uppercase;" wire:model="costo.no_factura" type="text"
                                            class="form-control form-control-sm" />
                                        @error('costo.no_factura')
                                            <span class="error text-danger">{{ $message }}<span>
                                        @enderror
                                    @else
                                        {{$item->no_factura ? $item->no_factura : 'N/A'}}
                                    @endif
                                </td>
                                <td>
                                    @if ($editMode)
                                        <button wire:click="removeCosto" class="btn btn-danger btn-xs"><i
                                                class="fa fa-times"></i> Cancelar</button>
                                    @else
                                        <button wire:click="editCosto({{ $item->id }})"
                                            class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>
        </div>

    </div>
</div>
