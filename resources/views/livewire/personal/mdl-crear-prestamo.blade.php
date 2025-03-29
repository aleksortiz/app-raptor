<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar prestamo a personal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="personal_id">Personal</label>
                            <select wire:model="personal_id" class="form-control @error('personal_id') is-invalid @enderror" id="personal_id">
                                <option value="">--Seleccione Personal--</option>
                                @foreach($personal as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('personal_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="monto">Monto Prestamo</label>
                            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: right;" wire:model="monto" type="text" class="form-control @error('monto') is-invalid @enderror" id="monto" placeholder="Monto">
                            @error('monto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="cuotas">Cuotas</label>
                            <input style="text-align: center;" wire:model="cuotas" type="text" class="form-control @error('cuotas') is-invalid @enderror" id="cuotas" placeholder="Cuotas">
                            @error('cuotas') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-4">
                        <h5>Cuota Semanal</h5>
                        <h4>@money($this->cuota_semanal)</h4>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="year">Año</label>
                            <input maxlength="4" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model="year" type="text" class="form-control @error('year') is-invalid @enderror" id="year" placeholder="Año">
                            @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="week">Semana</label>
                            <input maxlength="2" onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model="week" type="text" class="form-control @error('week') is-invalid @enderror" id="week" placeholder="Semana">
                            @error('week') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>


                    {{-- <div class="col-4">
                        <h5>Primer Descuento</h5>
                        <h4 x-text="fechaInicio"></h4>
                        @error('inicia') <span class="text-danger">{{ $message }}</span> @enderror
                    </div> --}}

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-success" wire:click="create"><i class="fas fa-check"></i> Registrar</button>
            </div>
        </div>
    </div>
</div>
