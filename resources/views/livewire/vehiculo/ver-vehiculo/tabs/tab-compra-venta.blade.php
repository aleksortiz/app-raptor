<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-6">
                <div class="form-group">
                    <label for="contratoVendedor">Vendedor</label>
                    <input type="text" class="form-control" wire:model.defer="contratoVendedor" style="text-transform: uppercase">
                    @error('contratoVendedor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-6">
                <div class="form-group">
                    <label for="contratoComprador">Comprador</label>
                    <input type="text" class="form-control" wire:model.defer="contratoComprador" style="text-transform: uppercase">
                    @error('contratoComprador') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-6">
                <div class="form-group">
                    <label for="contratoDomicilioComprador">Domicilio del Comprador</label>
                    <input type="text" class="form-control" wire:model.defer="contratoDomicilioComprador" style="text-transform: uppercase">
                    @error('contratoDomicilioComprador') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
        </div>
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-2">
                <div class="form-group">
                    <label for="contratoFecha">Fecha</label>
                    <input type="date" class="form-control" wire:model.defer="contratoFecha">
                    @error('contratoFecha') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="col-12 col-lg-4">
                <div class="form-group">
                    <label for="contratoLugar">Lugar</label>
                    <input type="text" class="form-control" wire:model.defer="contratoLugar" style="text-transform: uppercase">
                    @error('contratoLugar') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-3">
                <div class="form-group">
                    <label for="contratoPrecio">Precio de Venta</label>
                    <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right;" class="form-control" wire:model.defer="contratoPrecio">
                    @error('contratoPrecio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
    
            <div class="col-12 col-lg-3">
                <div class="form-group">
                    <label for="contratoAnticipo">Anticipo</label>
                    <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right;" class="form-control" wire:model.defer="contratoAnticipo">
                    @error('contratoAnticipo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-2 col-xl-2">
                <div class="form-group">
                    <label for="contratoPlazos">Plazos (Meses)</label>
                    <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" class="form-control" wire:model.defer="contratoPlazos">
                    @error('contratoPlazos') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
    
            <div class="col-12 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label for="contratoKilometraje">Kilometraje</label>
                    <input type="text" maxlength="10" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" class="form-control" wire:model.defer="contratoKilometraje">
                    @error('contratoKilometraje') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="offset-lg-3 col-12 col-lg-2">
                <div class="form-group">
                    <label for="contratoIdentificacion">Identificación</label>
                    <input type="text" class="form-control" wire:model.defer="contratoIdentificacion" style="text-transform: uppercase">
                    @error('contratoIdentificacion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
    
            <div class="col-12 col-lg-4">
                <div class="form-group">
                    <label for="contratoIdentificacionNumero">No. de Identificación</label>
                    <input type="text" class="form-control" wire:model.defer="contratoIdentificacionNumero" style="text-transform: uppercase">
                    @error('contratoIdentificacionNumero') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">

            <div class="offset-lg-3 col-12 col-lg-2 col-xl-1">
                <div class="form-group">
                    <label for="contratoSendMail">Enviar correo</label>
                        <label class="content-input">
                        <input id="contratoSendMail" wire:model="contratoSendMail" type="checkbox" />
                        <i></i>
                    </label>
                </div>
            </div>

            @if ($contratoSendMail)                
                <div class="col-12 col-lg-4 col-xl-5">
                    <div class="form-group">
                        <label for="contratoMail">Correo (Varios correos separados por coma)</label>
                        <input type="text" class="form-control" wire:model.defer="contratoMail" style="text-transform: lowercase">
                        @error('contratoMail') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="offset-lg-3 col-12 col-md-6">
                <center>
                    <button class="btn btn-success btn-lg" wire:click="createContrato"><i class="fa fa-handshake"></i> Crear Contrato</button>
                </center>
            </div>
        </div>
    
 
    </div>
    
</div>