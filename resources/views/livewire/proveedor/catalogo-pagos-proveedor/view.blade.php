<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pagos a Proveedores</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

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


            </div>

            <div class="row">

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i
                                class="fas fa-hand-holding-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Total Pagos</b></span>
                            <span class="info-box-number">@money(0)</span>
                        </div>

                    </div>
                </div>

                @foreach ($proveedores as $item)
                    <div class="col-sm-3">
                        <div class="info-box" wire:click="mdlPagar({{$item->id}})" style="cursor: pointer;">
                            <span class="info-box-icon bg-info elevation-1"><i
                                    class="fas fa-truck"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"><b>{{$item->nombre}}</b></span>
                                <span class="info-box-number">@money($item->getSumPagos($this->weekStart, $this->year))</span>
                            </div>

                        </div>
                    </div>
                @endforeach


            </div>

            {{-- <button class="btn btn-xs btn-success m-2" wire:click="mdlPagar"><i class="fas fa-plus"></i> Agregar Pago</button> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->proveedor->nombre }}</td>
                            <td>@money($row->monto)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{-- {{ $data->links() }} --}}

    @include('livewire.proveedor.catalogo-pagos-proveedor.modal')

</div>
