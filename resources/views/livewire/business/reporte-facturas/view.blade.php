<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h5>Facturas Pendientes</h5>
        </div>
        <div class="card-body">


            <div class="row p-3">

                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Año</label>
                        <select wire:model.lazy="year" class="form-control" id="year">
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

                <div class="col-2">
                    <div class="form-group">
                        <label for="keyWord">Orden / Folio</label>
                        <input wire:model.lazy="keyWord" type="text" class="form-control" id="keyWord">
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pagado (Fecha)</b></span>
                            <span class="info-box-number">@money($pagado)</span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Pendiente (Totalidad)</b></span>
                            <span class="info-box-number">@money($pendiente)</span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-1">
                    <button class="btn btn-xs btn-success mb-2" wire:click="exportToExcel"><i class="fas fa-file-excel"></i> E. Excel</button>
                </div>



            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Origen</th>
                        <th>Vehículo</th>
                        <th>Cliente</th>
                        <th>Razon Social</th>
                        <th>RFC</th>
                        <th>Dom. Fiscal</th>
                        <th>Concepto</th>
                        <th>Orden</th>
                        <th>Venta</th>
                        <th>Pagado</th>
                        <th>Factura</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through the invoices --}}
                    @foreach ($servicios as $item)
                    <tr>
                        <td>
                            @if ($item->model)
                                <a href="/servicios/{{$item->model->id}}" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> {{ $item->model?->folio_short }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-xs btn-{{$item->model?->origen_color}}">{{$item->model?->origen_short ?? ''}}</button>
                        </td>
                        <td>{{ $item->model?->vehiculo ?? 'N/A' }}</td>
                        <td>{{ $item->model?->cliente->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->model?->razon_social ?? 'N/A' }}</td>
                        <td>{{ $item->model?->rfc ?? 'N/A' }}</td>
                        <td>{{ $item->model?->domicilio_fiscal ?? 'N/A' }}</td>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->model?->orden ?? 'N/A' }}</td>
                        <td>@money($item->venta)</td>
                        <td>
                            @if ($item->pagado == null)
                                <button wire:click="mdlPagoServicios({{ $item->model->id }})" class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> PENDIENTE</button>
                            @else
                                <div style="cursor: pointer;" wire:click="mdlPagoServicios({{ $item->model->id }})">
                                    <i style="color: green;" class="fa fa-check"></i> Pagado:
                                    {{ $item->fecha_pago_format }}
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->no_factura ?? "N/A" }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $servicios->links() }}
            </div>


        </div>
    </div>

    @include('livewire.entrada.catalogo-entradas.modal-pago-servicios')
</div>
