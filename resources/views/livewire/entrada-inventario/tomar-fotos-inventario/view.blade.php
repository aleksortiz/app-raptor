<div>

    <div class="container py-2">
        @if ($this->firma)
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="text-center mb-4 font-weight-bold">Firma: {{$this->entrada->cliente->nombre}}</h2>
                            <div class="d-flex flex-column align-items-center">
                                <div wire:ignore class="mb-3">
                                    <canvas id="drawingCanvas" style="margin-top: 8px; border: 2px solid #ced4da; border-radius: 8px; background: #fff; width: 100%; max-width: 900px; height: 350px; display: block;"></canvas>
                                </div>
                                <div id="aceptarLeyenda" class="alert text-center font-weight-bold mb-3" style="font-size: 1.3rem; letter-spacing: 1px; background: #f8d7da; color: #721c24; border: 2px solid #f5c6cb; cursor: pointer; transition: background 0.3s, color 0.3s;" onclick="aceptarLeyendaClick()">
                                    <span id="iconoLeyenda"><i class="fa fa-exclamation-triangle mr-2"></i></span>ACEPTO QUE NO DEJO COSAS DE VALOR EN EL AUTO
                                </div>
                                <div class="btn-group mt-2" role="group">
                                    <button wire:click="fotos" class="btn btn-lg btn-warning"><i class="fa fa-camera"></i> Fotos ({{$this->entrada->fotos->count()}})</button>
                                    <button class="btn btn-lg btn-secondary ml-2" onclick="cleanCanvas()"><i class="fa fa-eraser"></i> Limpiar Firma</button>
                                    <button wire:click="guardarFirma" class="btn btn-lg btn-success ml-2" id="btnAceptarFirma" disabled><i class="fa fa-check"></i> Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            @php
                                $inv = json_decode($this->inventario->inventario);
                                $testigos = json_decode($this->inventario->testigos);
                            @endphp
                            <h4 class="mb-4 text-primary"><u>{{$this->entrada->vehiculo}}</u></h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Estereo:</strong> {{$inv->estereo}}</li>
                                <li class="list-group-item"><strong>Tapetes:</strong> {{$inv->tapetes}}</li>
                                <li class="list-group-item"><strong>Parabrisas:</strong> {{$inv->parabrisas}}</li>
                                <li class="list-group-item"><strong>Gato:</strong> {{$inv->gato}}</li>
                                <li class="list-group-item"><strong>Extra:</strong> {{$inv->extra}}</li>
                                <li class="list-group-item"><strong>Herramientas:</strong> {{$inv->herramientas}}</li>
                                <li class="list-group-item"><strong>Cables:</strong> {{$inv->cables}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body text-center">
                            <label class="h5">Cliente</label>
                            <h4>{{$this->entrada->cliente->nombre}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body text-center">
                            <label class="h5">Vehículo</label>
                            <h4>{{$this->entrada->vehiculo}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body text-center">
                            <label class="h5">Folio</label>
                            <h4>{{$this->entrada->folio_short}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div>
                        <label class="h5">Firmar</label><br>
                        <button wire:click="firmar" class="btn btn-md btn-primary mt-2"><i class="fa fa-marker"></i> FIRMA CLIENTE</button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    @livewire('fotos.subir-fotos', [
                        'model' => $this->entrada,
                        'storage_path' => 'entradas/fotos'
                    ])
                </div>
            </div>
        @endif

    </div>


</div>