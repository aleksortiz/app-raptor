<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->model->id ? 'Editar' : 'Crear' }} {{ $this->model_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-8">
                        <label>No. Reporte</label>
                        <input wire:model.defer="model.no_reporte" type="text" class="form-control" style="text-transform: uppercase;" />
                        @error('model.no_reporte')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-4">
                        <label>Sucursal</label>
                        <select wire:model.defer="model.sucursal_id" class="form-control">
                            <option value=""></option>
                            @foreach ($sucursales as $sucursal)
                                <option value={{ $sucursal->id }}>{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                        @error('model.sucursal_id')
                            <span class="error text-danger">Seleccione Sucursal</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label>Fabricante</label>
                        <input list="fabricantes" wire:model.defer="model.fabricante" type="text" class="form-control" style="text-transform: uppercase;" />
                        <datalist id="fabricantes">
                            @foreach ($fabricantes as $item)
                                <option value="{{$item}}">
                            @endforeach
                        </datalist>
                        @error('model.fabricante')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label>Modelo</label>
                        <input list="modelos" wire:model.defer="model.modelo" type="text" class="form-control" style="text-transform: uppercase;" />
                        <datalist id="modelos">
                            @foreach ($modelos as $item)
                                <option value="{{ $item }}">
                            @endforeach
                        </datalist>
                        @error('model.fabricante')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label>Notas</label>
                        <textarea wire:model.defer="model.notas" class="form-control"></textarea>
                        @error('model.notas')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->model->id)
                    <button type="button" wire:click="save" class="btn btn-primary"><i
                            class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click="save" class="btn btn-success"><i
                            class="fas fa-check"></i> Crear Evaluación</button>
                @endif

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
