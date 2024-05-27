<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">


        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total Sueldos:</b></span>
                      <span class="info-box-number">@money($this->entrada->pagos_personal->sum('pago'))</span>
                    </div>
        
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Fecha</th>
                            <th>Personal</th>
                            <th>Porcentaje</th>
                            <th>Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->pagos_personal as $item)
                        <tr>
                            {{-- <td><button class="btn btn-xs btn-danger" onclick="destroy({{$item->id}},'material','destroyMaterial')"><i class="fa fa-trash-alt"></i></button></td> --}}
                            <td>{{$item->fecha}}</td>
                            <td>{{$item->personal->nombre}}</td>
                            <td>
                                @if ($item->porcentaje > 0)
                                    {{ $item->porcentaje }} %
                                @else
                                    <button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> TIEMPO EXTRA</button>
                                @endif
                            </td>
                            <td>@money($item->pago)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>