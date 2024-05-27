<div>
    <a href="/servicios/{{$this->entrada->id}}/area-trabajo" class="btn btn-xs btn-warning"><i class="fa fa-wrench"></i> Editar Areas</a>


    <div class="row">
    
        @php
            $url = asset("images/car-parts");
            $areas = json_decode($this->entrada->area_trabajo);
    
            $front= ['FRONTAL'];
            $back= ['TRASERO'];
            $right_side= ['TRASERO DERECHO', 'PUERTA TRASERA DERECHA', 'PUERTA DERECHA', 'FRONTAL DERECHO'];
            $left_side= ['TRASERO IZQUIERDO', 'PUERTA TRASERA IZQUIERDA', 'PUERTA IZQUIERDA', 'FRONTAL IZQUIERDO'];
            $top= ['COFRE', 'PARABRISAS', 'TECHO', 'PARABRISAS TRASERO', 'MALETERO'];
        @endphp

        @if (count($areas) <= 0)    
            <div class="col-12">
                <h1>No existen areas de trabajo</h1>
            </div>
        @endif
    
    
    
        @if (count(array_intersect($areas, $front)) > 0)
            <div class="col-md-6 col-sm-12">
                <center>
                    <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="FRONTAL" src="{{ $url . ( in_array('FRONTAL', $areas) ? "-selected" : "") . "/front.png" }}" height="180px">
                </center>
            </div>
        @endif
    
    
        @if (count(array_intersect($areas, $right_side)) > 0)
            <div class="col-md-6 col-sm-12">
                <center>
    
                    <div style="display:flex; margin: 0px;">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="TRASERO DERECHO" src="{{ $url . ( in_array('TRASERO DERECHO', $areas) ? "-selected" : "") . "/right/back.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PUERTA TRASERA DERECHA" src="{{ $url . ( in_array('PUERTA TRASERA DERECHA', $areas) ? "-selected" : "") . "/right/back-door.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PUERTA DERECHA" src="{{ $url . ( in_array('PUERTA DERECHA', $areas) ? "-selected" : "") . "/right/front-door.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="FRONTAL DERECHO" src="{{ $url . ( in_array('FRONTAL DERECHO', $areas) ? "-selected" : "") . "/right/front.png" }}" height="150px">
                    </div>
    
                </center>
            </div>
        @endif
    
    
        @if (count(array_intersect($areas, $back)) > 0)
            <div class="col-md-6 col-sm-12">
                <center>
                    <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="TRASERO" src="{{ $url . ( in_array('TRASERO', $areas) ? "-selected" : "") . "/back.png" }}" height="180px">
                </center>
            </div>
        @endif
    
    
        @if (count(array_intersect($areas, $left_side)) > 0)
            <div class="col-md-6 col-sm-12">
                <center>
    
                    <div style="display:flex; margin: 0px;">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="FRONTAL IZQUIERDO" src="{{ $url . ( in_array('FRONTAL IZQUIERDO', $areas) ? "-selected" : "") . "/left/front.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PUERTA IZQUIERDA" src="{{ $url . ( in_array('PUERTA IZQUIERDA', $areas) ? "-selected" : "") . "/left/front-door.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PUERTA TRASERA IZQUIERDA" src="{{ $url . ( in_array('PUERTA TRASERA IZQUIERDA', $areas) ? "-selected" : "") . "/left/back-door.png" }}" height="150px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="TRASERO IZQUIERDO" src="{{ $url . ( in_array('TRASERO IZQUIERDO', $areas) ? "-selected" : "") . "/left/back.png" }}" height="150px">
                    </div>
    
                </center>
            </div>
        @endif
    
        
        @if (count(array_intersect($areas, $top)) > 0)
            <div class="col-md-6 col-sm-12">
                <center>
                    <div style="display:flex; margin: 0px;">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="COFRE" src="{{ $url . ( in_array('COFRE', $areas) ? "-selected" : "") . "/top/cofre.png" }}" height="180px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PARABRISAS" src="{{ $url . ( in_array('PARABRISAS', $areas) ? "-selected" : "") . "/top/parabrisas-frontal.png" }}" height="180px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="TECHO" src="{{ $url . ( in_array('TECHO', $areas) ? "-selected" : "") . "/top/techo.png" }}" height="180px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="PARABRISAS TRASERO" src="{{ $url . ( in_array('PARABRISAS TRASERO', $areas) ? "-selected" : "") . "/top/parabrisas-trasero.png" }}" height="180px">
                        <img style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="MALETERO" src="{{ $url . ( in_array('MALETERO', $areas) ? "-selected" : "") . "/top/cajuela.png" }}" height="180px">
                    </div>
    
                </center>
            </div>
        @endif
    
    </div>
</div>
