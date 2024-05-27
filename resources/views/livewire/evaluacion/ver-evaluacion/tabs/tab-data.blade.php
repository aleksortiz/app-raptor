<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <h3>{{$evaluacion->vehiculo}}</h3>
                <h5><b>Sucursal:</b><br> {{$evaluacion->sucursal->nombre}}
                </h5>
                <hr>
        
                @if ($evaluacion->no_reporte)
                    <h5><b>No. Reporte:</b><br> {{$evaluacion->no_reporte}}</h5>
                    <hr>
                @endif

        
                @if ($evaluacion->fabricante)
                    <h5><b>Fabricante:</b><br> {{$evaluacion->fabricante}}</h5>
                    <hr>
                @endif

                @if ($evaluacion->modelo)
                    <h5><b>Modelo:</b><br> {{$evaluacion->modelo}}</h5>
                    <hr>
                @endif

                @if ($evaluacion->notas)
                    <h5><b>Notas:</b></h5>
                    <p>{{$evaluacion->notas}}</p>
                    <hr>
                @endif

                <center>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#mdl"><i class="fas fa-edit"></i> Editar Evaluación</button>
                </center>


            </div>
            <div class="col-9">
                @livewire('fotos.subir-fotos', [
                    'model' => $evaluacion,
                    'storage_path' => 'evaluaciones/fotos'
                ])

            </div>
        </div>
        
        
    </div>
</div>