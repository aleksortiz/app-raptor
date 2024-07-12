
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Reporte de Comisiones</h3>
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

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Costo</b></span>
                            <span class="info-box-number">@money($refacciones->sum('costo_total'))</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-3">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Venta</b></span>
                            <span class="info-box-number">@money($refacciones->sum('importe'))</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-3">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Utilidad</b></span>
                            <span class="info-box-number">@money($refacciones->sum('utilidad'))</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-3">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-red elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Comisión</b></span>
                            <span class="info-box-number">@money($refacciones->sum('comision'))</span>
                        </div>
    
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Entrada</th>
                        <th>Vehículo</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th>Venta</th>
                        <th>Utilidad</th>
                        <th>Comisión</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($refacciones ?? [] as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="/servicios/{{$row->model_id}}"><i class="fa fa-car"></i> {{ $row->model->folio_short }}</a>
                            </td>
                            <td>{{ $row->model->vehiculo }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>@money($row->costo_total)</td>
                            <td>@money($row->importe)</td>
                            <td>@money($row->utilidad)</td>
                            <td>@money($row->comision)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $refacciones->links() }}

</div>