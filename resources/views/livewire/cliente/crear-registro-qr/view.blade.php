<div class="card mt-4">

    <style>
        input[type="number"] {
            appearance: textfield;
            -moz-appearance: textfield; /* Firefox */
            -webkit-appearance: textfield; /* Safari y Chrome */
        }
    </style>

    <div class="card-header text-center">
        <h3 class="card-title">Bienvenido a Autoservicio-Raptor</h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5"> <!-- Sección centrada y con un ancho controlado -->

                <center>
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Autoservicio-Raptor">
                </center>

                <h2 class="text-center">Registro de Cita</h2>

                <div class="form-group">
                    <label for="nombre_cliente">Nombre</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" maxlength="255" id="nombre_cliente" class="form-control" wire:model.defer="nombre_cliente">
                    @error('nombre_cliente') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="numero_reporte">Número de Reporte</label>
                    <input type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-transform: uppercase; text-align: center;" maxlength="11" id="numero_reporte" class="form-control" wire:model.defer="numero_reporte">
                    @error('numero_reporte') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="marca">Marca del Vehículo</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" maxlength="180" id="marca" list="marcas" class="form-control" wire:model.defer="marca">
                    <datalist id="marcas">
                        @foreach ($marcas as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" maxlength="180" id="modelo" list="modelos" class="form-control" wire:model.defer="modelo">
                    <datalist id="modelos">
                        @foreach ($modelos as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="year">Año del Vehículo</label>
                    <input style="text-align: center;" maxlength="4" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" id="year" class="form-control" wire:model.defer="year">
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color del Vehículo</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" maxlength="30" id="color" class="form-control" wire:model.defer="color">
                    @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-7">
                        <div class="form-group">
                            <label for="fecha_cita">Fecha de Cita</label>
                            <input type="date" id="fecha_cita" class="form-control" wire:model.lazy="fecha_cita">
                            @error('fecha_cita') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if ($this->fecha_cita)
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="form-group">
                                <label for="hora_cita">Hora de la Cita</label>
                                <select id="hora_cita" class="form-control" wire:model.defer="hora_cita">
                                    <option value="">--Seleccione Hora--</option>
                                    @foreach ($horas_disponibles as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                
                    @endif

                </div>


                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="ine_frontal">INE Frontal</label><br>
                            <label class="btn btn-md btn-warning m-1 p-2">
                                <i class="fa fa-id-card"></i>
                                Subir INE Frontal
                                <input wire:model="ine_frontal_file" accept="image/*" style="display: none;" type="file">
                            </label>

                            <center>
                                <img style="height: 210; width: 315px; object-fit:cover" src="{{ $ine_frontal_file?->temporaryUrl() ?? "" }}" class="img-fluid mb-2" alt="image" />
                            </center>

                            @error('ine_frontal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="ine_reverso">INE Reverso</label><br>
                            <label class="btn btn-md btn-warning m-1 p-2">
                                <i class="fa fa-id-card"></i>
                                Subir INE Reverso
                                <input wire:model="ine_reverso_file" accept="image/*" style="display: none;" type="file">
                            </label>

                            <center>
                                <img style="height: 210; width: 315px; object-fit:cover" src="{{ $ine_reverso_file?->temporaryUrl() ?? "" }}" class="img-fluid mb-2" alt="image" />
                            </center>

                            @error('ine_reverso') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>



                <div style="margin-top: 40px;" class="form-group text-center">
                    <button wire:click="aceptar" class=" btn btn-lg btn-block btn-success"><i class="fa fa-calendar-alt"></i> Registrar Cita</button>
                </div>
            </div>
        </div>
    </div>
</div>
