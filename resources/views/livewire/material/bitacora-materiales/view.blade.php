
@section('title', __("Bitacora de Materiales"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bitacora de Materiales</h3>
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

                <div class="col-1">
                    <div class="form-group">
                        <label for="iptDesglosar">Desglosar</label>
                        {{-- <input wire:model="desglosar" type="checkbox"  id="iptDesglosar"> --}}
                        <label class="content-input">
                            <input wire:model="desglosar" type="checkbox" />
                            <i></i>
                        </label>
                    </div>
                </div>


            </div>

            <div class="row p-2">
                {{-- <div class="col-md-4 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wrench"></i></span>
    
                    <div class="info-box-content">
                      <span class="info-box-text"><b>Refacciones</b></span>
                      <span class="info-box-number">@money($this->totalRefacciones)</span>
                    </div>

                  </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cubes"></i></span>
      
                      <div class="info-box-content">
                        <span class="info-box-text"><b>Materiales</b></span>
                        <span class="info-box-number">@money($this->totalMateriales)</span>
                      </div>

                    </div>
                </div> --}}

                <div class="col-md-4 col-sm-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
      
                      <div class="info-box-content">
                        <span class="info-box-text"><b>Total Material</b></span>
                        <span class="info-box-number">@money($this->totalMateriales)</span>
                      </div>

                    </div>
                </div>

            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>{{$this->desglosar ? "Folio" : "Entradas"}}</th>
                        <th>Material</th>
                        <th>Unidad de Medida</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materiales as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->fecha_creacion }}</td>
                        <td>
                            @if($this->desglosar)
                                @if ($row->entrada)
                                    <a target="_blank" href="/servicios/{{$row->entrada_id}}?activeTab=6" class="btn btn-xs btn-primary p-2"><i class="fa fa-car mr-1"></i> {{ $row->entrada->folio_short }}</a>
                                @else
                                    <button class="btn btn-xs btn-warning p-2"><i class="fa fa-car mr-1"></i> TALLER</button>
                                @endif
                            @else
                                <a target="_blank" href="/servicios/{{$row->entrada_id}}?activeTab=6" class="btn btn-xs btn-primary p-2"><i class="fa fa-car mr-1"></i> {{ $row->c_entradas }}</a>
                            @endif



                        </td>
                        <td>{{ $row->material }}</td>
                        <td>{{ $row->unidad_medida }}</td>
                        <td>@float($row->cantidadSum)</td>
                        <td>@money($row->precio)</td>
                        <td>@money($row->importeSum)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{-- {{ $materiales->links() }} --}}

</div>
