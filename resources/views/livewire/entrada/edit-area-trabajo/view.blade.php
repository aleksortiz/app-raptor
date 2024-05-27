@section('title', __('Generar Entrada'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Folio: {{$this->entrada->folio_short}} - {{$this->entrada->vehiculo}}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <button wire:click="back" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</button>
            <button wire:click="save" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Datos</button>
            <br>
            <br>
            <h2>Areas de Trabajo</h2>
            <div class="row">

                <div class="col">
                    <center>
                        <img style="cursor: pointer;" wire:click="selectPart('FRONTAL')" data-toggle="tooltip" data-placement="top" title="FRONTAL" src="{{ asset("images/car-parts" . ( in_array('FRONTAL', $this->areas) ? "-selected" : "") . "/front.png") }}" height="180px">
                        <img style="cursor: pointer;" wire:click="selectPart('TRASERO')" data-toggle="tooltip" data-placement="top" title="TRASERO" src="{{ asset("images/car-parts" . ( in_array('TRASERO', $this->areas) ? "-selected" : "") . "/back.png") }}" height="180px">
                    </center>
                </div>


                <div class="col">
                    <center>
        
                        <div style="display:flex; margin: 0px;">
                            <img style="cursor: pointer;" wire:click="selectPart('TRASERO DERECHO')" data-toggle="tooltip" data-placement="top" title="TRASERO DERECHO" src="{{ asset("images/car-parts" . ( in_array('TRASERO DERECHO', $this->areas) ? "-selected" : "") . "/right/back.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PUERTA TRASERA DERECHA')" data-toggle="tooltip" data-placement="top" title="PUERTA TRASERA DERECHA" src="{{ asset("images/car-parts" . ( in_array('PUERTA TRASERA DERECHA', $this->areas) ? "-selected" : "") . "/right/back-door.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PUERTA DERECHA')" data-toggle="tooltip" data-placement="top" title="PUERTA DERECHA" src="{{ asset("images/car-parts" . ( in_array('PUERTA DERECHA', $this->areas) ? "-selected" : "") . "/right/front-door.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('FRONTAL DERECHO')" data-toggle="tooltip" data-placement="top" title="FRONTAL DERECHO" src="{{ asset("images/car-parts" . ( in_array('FRONTAL DERECHO', $this->areas) ? "-selected" : "") . "/right/front.png") }}" height="180px">
                        </div>
        
                    </center>
                </div>


            </div>

            <div class="row">

                <div class="col">
                    <center>
                        <div style="display:flex; margin: 0px;">
                            <img style="cursor: pointer;" wire:click="selectPart('COFRE')" data-toggle="tooltip" data-placement="top" title="COFRE" src="{{ asset("images/car-parts" . ( in_array('COFRE', $this->areas) ? "-selected" : "") . "/top/cofre.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PARABRISAS')" data-toggle="tooltip" data-placement="top" title="PARABRISAS" src="{{ asset("images/car-parts" . ( in_array('PARABRISAS', $this->areas) ? "-selected" : "") . "/top/parabrisas-frontal.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('TECHO')" data-toggle="tooltip" data-placement="top" title="TECHO" src="{{ asset("images/car-parts" . ( in_array('TECHO', $this->areas) ? "-selected" : "") . "/top/techo.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PARABRISAS TRASERO')" data-toggle="tooltip" data-placement="top" title="PARABRISAS TRASERO" src="{{ asset("images/car-parts" . ( in_array('PARABRISAS TRASERO', $this->areas) ? "-selected" : "") . "/top/parabrisas-trasero.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('MALETERO')" data-toggle="tooltip" data-placement="top" title="MALETERO" src="{{ asset("images/car-parts" . ( in_array('MALETERO', $this->areas) ? "-selected" : "") . "/top/cajuela.png") }}" height="180px">
                        </div>
        
                    </center>
                </div>


                <div class="col">
                    <center>

                        <div style="display:flex; margin: 0px;">
                            <img style="cursor: pointer;" wire:click="selectPart('FRONTAL IZQUIERDO')" data-toggle="tooltip" data-placement="top" title="FRONTAL IZQUIERDO" src="{{ asset("images/car-parts" . ( in_array('FRONTAL IZQUIERDO', $this->areas) ? "-selected" : "") . "/left/front.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PUERTA IZQUIERDA')" data-toggle="tooltip" data-placement="top" title="PUERTA IZQUIERDA" src="{{ asset("images/car-parts" . ( in_array('PUERTA IZQUIERDA', $this->areas) ? "-selected" : "") . "/left/front-door.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('PUERTA TRASERA IZQUIERDA')" data-toggle="tooltip" data-placement="top" title="PUERTA TRASERA IZQUIERDA" src="{{ asset("images/car-parts" . ( in_array('PUERTA TRASERA IZQUIERDA', $this->areas) ? "-selected" : "") . "/left/back-door.png") }}" height="180px">
                            <img style="cursor: pointer;" wire:click="selectPart('TRASERO IZQUIERDO')" data-toggle="tooltip" data-placement="top" title="TRASERO IZQUIERDO" src="{{ asset("images/car-parts" . ( in_array('TRASERO IZQUIERDO', $this->areas) ? "-selected" : "") . "/left/back.png") }}" height="180px">
                        </div>
        
                    </center>
                </div>


            </div>



        </div>
    </div>
</div>
