@section('title', __('Gastos Fijos'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gastos Fijos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

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
                        <select wire:model="week" class="form-control" id="week">
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i
                                class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Total Gastos: </b></span>
                            <span class="info-box-number">@money($this->totalGastos)</span>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col ml-4 mb-3">
                    <button wire:click="saveGastos" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar Gastos</button>
                    <button wire:click="mdlGasto" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar Gasto</button>
                </div>
            </div>

            <div class="row">
                <div class="col-6">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gasto</th>
                                <th width="30%">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gastos as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item }}</td>
                                    <td><input wire:model.defer="bills.{{$loop->index}}.monto" class="form-control" style="text-align: right;" type="text"
                                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.gastos-fijos.capturar-gastos-fijos.modal')
</div>
