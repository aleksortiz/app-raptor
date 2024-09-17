<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$this->selected_costo?->model?->folio_short}} - {{$this->selected_costo?->model?->vehiculo}}: {{$this->selected_costo?->concepto}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>

                  <div>
                    <div class="row @if($this->selected_costo?->porcentaje_asignado > $this->selected_costo?->porcentaje_mo) text-danger @endif">
                      <div class="col">
                        <div class="form-group">
                            <label>Presupuesto para M.O.</label>
                            <h3>@money($this->selected_costo?->presupuesto_mo)</h3>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                            <label>Asignado</label>
                            <h3>@money($this->selected_costo?->asignado)</h3>
                        </div>
                      </div>

                      <div class="col">
                        <div class="form-group">
                            <label>Porcentaje Asignado</label>
                            <h3>{{$this->selected_costo?->porcentaje_asignado}}%</h3>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label>Personal</label>
                            <select wire:model.defer="personal_id" class="form-control">
                                <option value="">Seleccione...</option>
                                @foreach ($personal as $personal)
                                    <option value="{{ $personal->id }}">{{ $personal->nombre }}</option>
                                @endforeach
                            </select>
                            @error('personal_id') <span class="error text-danger">Seleccione Personal</span> @enderror
                        </div>
                        <div class="form-group col">
                            <label>Porcentaje (%)</label>
                            <input style="text-align: center" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" wire:model.lazy="porcentaje" class="form-control">
                            @error('porcentaje') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col">
                            <label>Monto</label>
                            <input style="text-align: right" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" wire:model.lazy="monto" class="form-control">
                            @error('monto') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label>Concepto</label>
                            <textarea rows="4" type="text" wire:model.defer="notas" class="form-control"></textarea>
                            @error('notas') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="createOrdenTrabajo" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
