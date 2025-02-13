<div class="card mt-4">
    <div class="card-header text-center">
        <h3 class="card-title">Bienvenido a Autoservicio-Raptor</h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5"> <!-- Sección centrada y con un ancho controlado -->

                <center>
                    <img style="height: 180px;" src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo de Autoservicio-Raptor">
                </center>

                <h1 class="text-center">Registro de Cita</h1>

                <div class="form-group">
                    <label for="nombre_cliente">Nombre</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" id="nombre_cliente" class="form-control" wire:model.defer="nombre_cliente">
                    @error('nombre_cliente') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="numero_reporte">Número de Reporte</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" id="numero_reporte" class="form-control" wire:model.defer="numero_reporte">
                    @error('numero_reporte') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" id="marca" list="marcas" class="form-control" wire:model.defer="marca">
                    <datalist id="marcas">
                        @foreach ($marcas as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" style="text-transform: uppercase; text-align: center;" id="modelo" list="modelos" class="form-control" wire:model.defer="modelo">
                    <datalist id="modelos">
                        @foreach ($modelos as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="year">Año</label>
                    <input maxlength="4" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" id="year" class="form-control" wire:model.defer="year">
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
