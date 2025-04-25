<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        {{-- <button wire:click="showMdlMaterialManual" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Registro Manual</button> --}}

        <div class="row ml-2 mt-3">
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>Total Materiales:</b></span>
                      <span class="info-box-number">@money($this->entrada->total_materiales)</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- <button wire:click="showMdlMateriales" class="m-2 btn btn-xs btn-success"><i class="fa fa-plus"></i> Agregar Material</button> --}}

        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Fecha</th>
                            <th>Trabajador</th>
                            <th>Número de Parte</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->entrada->materiales as $item)
                        <tr>
                            {{-- <td><button class="btn btn-xs btn-danger" onclick="destroy({{$item->id}},'material','destroyMaterial')"><i class="fa fa-trash-alt"></i></button></td> --}}
                            <td>{{$item->fecha_creacion}}</td>
                            <td>{{$item->vale_material?->personal->nombre ?? 'INDEFINIDO'}}</td>
                            <td>{{$item->numero_parte}}</td>
                            <td>{{$item->material}}</td>
                            <td>{{$item->cantidad}}</td>
                            <td>@money($item->precio)</td>
                            <td>@money($item->importe)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
