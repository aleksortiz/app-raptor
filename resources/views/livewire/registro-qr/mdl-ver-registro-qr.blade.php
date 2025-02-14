<div>

    <script>
        function downloadImage(imageUrl, fileName) {
            const link = document.createElement("a");
            link.href = imageUrl;
            link.download = fileName;

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>


    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registro de Cita</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
    
                            <h5>Cliente</h5>
                            <p>{{ $this->registro_qr?->cliente_nombre }}</p>
                            <hr>
    
                            <h5>Vehículo</h5>
                            <p>{{ $this->registro_qr?->vehiculo }}</p>
                            <hr>
    
                            <h5>Teléfono</h5>
                            <p>{{ $this->registro_qr?->telefono }}</p>
                            <hr>
    
                            @if ($this->registro_qr?->correo)                            
                                <h5>Correo</h5>
                                <p>{{ $this->registro_qr?->correo }}</p>
                                <hr>
                            @endif
    
    
                        </div>
                        <div class="col-3">
    
                            <h5>Reporte</h5>
                            <p>{{ $this->registro_qr?->numero_reporte }}</p>
                            <hr>
    
                            <h5>Fecha de Cita</h5>
                            <p>{{ $this->registro_qr?->fecha_cita_format }}</p>
                            <hr>
    
                            <h5>Cita para:</h5>
                            <p>{!! $this->registro_qr?->tipo_span !!}</p>
                            <hr>

                            <h5>Eliminar Cita:</h5>
                            <button onclick="destroy({{$this->registro_qr?->id}}, 'Cita', 'deleteRegistro')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</button>
                            <hr>
    
    
                        </div>
    
                        <div class="col-6">
                            <h4 class="text-center">Documentos</h4>
                            <hr>
    
                            @if ($this->registro_qr?->orden_admision)
                                <div wire:loading.remove wire:target="download_orden_admision" class="text-center">
                                    <h5 class="text-center">Orden de Admisión</h5>
                                </div>
                                <div wire:loading wire:target="download_orden_admision" class="text-center">
                                    <h5 class="text-center"><i class="fa fa-spin fa-spinner"></i> Descargando...</h5>
                                </div>
                                <center>
                                    <button wire:click="download_orden_admision" class="btn btn-success btn-md"><i class="fa fa-file-pdf"></i> ODA #{{$this->registro_qr?->numero_reporte}}</button>
                                </center>
                                <hr>
                            @endif

                            @if ($this->registro_qr?->ine_frontal)
                            
                                <div wire:loading.remove wire:target="downloadIneFrontal" class="text-center">
                                    <h5 class="text-center">INE Frontal</h5>
                                </div>
                                <div wire:loading wire:target="downloadIneFrontal" class="text-center">
                                    <h5 class="text-center"><i class="fa fa-spin fa-spinner"></i> Descargando...</h5>
                                </div>
                                <center>
                                    <button wire:click="downloadIneFrontal" >
                                        <img style="width: 50%;" src="{{ $this->registro_qr?->ine_frontal }}" alt="INE Frontal" class="img-fluid">
                                    </button>
                                </center>
                                <hr>
                            @endif


                            @if ($this->registro_qr?->ine_reverso)
                                <div wire:loading.remove wire:target="download_ine_reverso" class="text-center">
                                    <h5 class="text-center">INE Reverso</h5>
                                </div>
                                <div wire:loading wire:target="download_ine_reverso" class="text-center">
                                    <h5 class="text-center"><i class="fa fa-spin fa-spinner"></i> Descargando...</h5>
                                </div>
                                <center>
                                    <button wire:click="download_ine_reverso" >
                                        <img style="width: 50%;" src="{{ $this->registro_qr?->ine_reverso }}" alt="INE Reverso" class="img-fluid">
                                    </button>
                                </center>
                            @endif
    
    
                        </div>
                    </div>
    
      
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="create"><i class="fas fa-check"></i> Registrar</button>
                </div>
            </div>
        </div>
    </div>
      

</div>
