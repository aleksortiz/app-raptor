<div class="pt-3">
    <div style="min-height: 85vh" class="card">
        <div class="card-header">
            <h3 class="card-title">Depósito</h3>
        </div>
        <div class="card-body ">

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

                <div class="col-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Total</b></span>
                            <span class="info-box-number">@money($total)</span>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <button wire:click="mdlCreate" class="mt-5 btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registar Depósito</button>
                </div>

            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresos as $ingreso)
                        <tr>
                            <td>{{ $ingreso->fecha_format }}</td>
                            <td>{{ $ingreso->user->name }}</td>
                            <td>{{ $ingreso->concepto }}</td>
                            <td>@money($ingreso->monto)</td>
                            <td><button onclick="confirm('Eliminar Ingreso', 'remove', {{$ingreso->id}})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @include('livewire.business.capturar-ingresos.modal')
</div>
