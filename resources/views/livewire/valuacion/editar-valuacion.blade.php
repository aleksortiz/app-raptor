<div class="card m-0" style="min-height: 65vh;">

    @livewire('cliente.common.mdl-select-cliente')

    <div style="overflow: scroll;" class="card-body">

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="numero_reporte">No. Reporte</label>
                    <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="11" wire:model.defer="numero_reporte" type="text" class="form-control" id="numero_reporte" placeholder="No. Reporte">
                    @error('numero_reporte') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="form-group">
                    @if($this->cliente_id)
                        <button wire:click="$emit('setCliente', 0)" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></button>
                    @else
                        <button wire:click="$emit('showModal', '#mdlSelectCliente')" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>
                    @endif
                    <label for="cliente_name">Cliente</label>
                    <input disabled wire:model.defer="cliente_name" type="text" class="form-control" id="cliente_name" placeholder="Seleccione Cliente">
                    @error('cliente_id') <span class="text-danger">Seleccione Cliente</span> @enderror
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input wire:model.defer="marca" type="text" list="marcas" class="form-control" id="marca" placeholder="Marca">
                    <datalist id="marcas">
                        @foreach ($marcas as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input wire:model.defer="modelo" type="text" list="modelos" class="form-control" id="modelo" placeholder="Modelo">
                    <datalist id="modelos">
                        @foreach ($modelos as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                    @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="year">Año</label>
                    <input wire:model.defer="year" maxlength="4" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" id="year" placeholder="Año">
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="color">Color</label>
                    <input wire:model.defer="color" type="text" class="form-control" id="color" placeholder="Color">
                    @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label for="grua">Es grua</label>
                <label class="content-input">
                    <input type="checkbox" id="grua" wire:model.defer="grua">
                    <i></i>
                </label>
            </div>

            <div class="col-12 col-md-3">
                <label for="valuacion_efectuada">Valuación efectuada</label>
                <label class="content-input">
                    <input type="checkbox" id="valuacion_efectuada" wire:model.defer="valuacion_efectuada">
                    <i></i>
                </label>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="fecha_cita">Fecha de Cita:</label>
                    <input wire:model.defer="fecha_cita" type="datetime-local" class="form-control" id="fecha_cita">
                    @error('fecha_cita') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="notas">Notas</label>
                    <textarea wire:model.defer="notas" type="text" rows="3" style="resize: none;" maxlength="255" class="form-control" id="notas" placeholder="Notas ó Comentarios"></textarea>
                    @error('notas') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>


    </div>

    <div class="card-footer">
        <button class="btn btn-primary" wire:click="save" ><i class="fas fa-save"></i> Guardar Valuación</button>
    </div>
</div>
