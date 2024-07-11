<div style="height: 75vh;" class="card">
    <div class="card-header">
        <h3 class="card-title">{{$this->selectedUnidad->vehiculo}}</h3>
        <div class="card-tools">
            <button type="button" wire:click="back" class="btn btn-xs btn-secondary"><i class="fas fa-arrow-left"></i> Regresar</button>
        </div>
    </div>
    <div class="card-body p-0">

        <div class="ml-3 mt-2">
            <h5>Placas: {{ $this->selectedUnidad->placas ? $this->selectedUnidad->placas : "N/A" }}</h5>
            <h5>Estado: {{ $this->selectedUnidad->estado }}</h5>
            <h5>Kilometraje: @qty($this->selectedUnidad->kilometraje)</h5>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->selectedUnidad->servicios as $row)
                <tr>
                    <td>{{ $row->tipo_servicio }}</td>
                    <td>{{ $row->descripcion }}</td>
                    <td>{{ $row->fecha }}</td>
                    <td>@money($row->costo)</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>