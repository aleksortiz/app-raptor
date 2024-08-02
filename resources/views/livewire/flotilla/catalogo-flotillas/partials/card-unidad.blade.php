<div style="height: 75vh;" class="card">
    <div class="card-header">
        <button style="float: left" type="button" wire:click="back" class="btn btn-xs btn-secondary"><i class="fas fa-arrow-left"></i> Regresar</button>
        <h3 style="float: left" class="ml-2 card-title">{{$this->selectedUnidad->vehiculo}}</h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body p-0">

        <div class="ml-3 mt-2">
            <h5>Placas: {{ $this->selectedUnidad->placas ? $this->selectedUnidad->placas : "N/A" }}</h5>
            <h5>Estado: {{ $this->selectedUnidad->estado }}</h5>
            <h5>Kilometraje: @qty($this->selectedUnidad->kilometraje)</h5>
            <button wire:click="mdlCrearServicio" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Registrar Servicio</button>
        </div>

        <h3 class="m-3">Servicios: </h3>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Costo</th>
                    <th>Estatus</th>
                    <th>Fotos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->selectedUnidad->servicios as $row)
                <tr>
                    <td>{{ $row->tipo_servicio }}</td>
                    <td>{{ $row->descripcion }}</td>
                    <td>{{ $row->fecha_servicio_format }}</td>
                    <td>@money($row->costo)</td>
                    <td><button wire:click="selectServicio({{$row->id}})" class="{{$row->estatus_servicio_btn}}"><i class="fa fa-car"></i> {{$row->estatus_servicio}}</button></td>
                    <td><button wire:click="mdlFotosServicio({{$row->id}})" class="btn btn-xs btn-primary"><i class="fa fa-camera"></i> Fotos</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>