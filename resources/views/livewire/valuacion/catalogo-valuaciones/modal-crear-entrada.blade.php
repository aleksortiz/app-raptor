<!-- Modal para crear Entrada -->
<div wire:ignore.self class="modal fade" id="modalCrearEntrada" tabindex="-1" role="dialog" aria-labelledby="modalCrearEntradaLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable9" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearEntradaLabel">Crear Entrada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="cancelar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="guardarEntrada">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="origen">Origen</label>
                                <select class="form-control" id="origen" wire:model="origen">
                                    <option value="ASEGURADORA">ASEGURADORA</option>
                                    <option value="PARTICULAR">PARTICULAR</option>
                                    <option value="AGENCIA">AGENCIA</option>
                                    <option value="GARANTIA">GARANTÍA</option>
                                    <option value="INTERNO">INTERNO</option>
                                </select>
                                @error('origen') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control" id="marca" wire:model="marca" list="marcas-list">
                                <datalist id="marcas-list">
                                    @foreach(json_decode(file_get_contents(app_path('Data/marcas.json'))) as $marca)
                                        <option value="{{ $marca }}">
                                    @endforeach
                                </datalist>
                                @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" wire:model="modelo">
                                @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="yearVehiculo">Año</label>
                                <input type="number" class="form-control" id="yearVehiculo" wire:model="yearVehiculo">
                                @error('yearVehiculo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" wire:model="color">
                                @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serie">Serie/VIN</label>
                                <input type="text" class="form-control" id="serie" wire:model="serie">
                                @error('serie') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="placas">Placas</label>
                                <input type="text" class="form-control" id="placas" wire:model="placas">
                                @error('placas') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="noReporte">Número de Reporte</label>
                                <input type="text" class="form-control" id="noReporte" wire:model="noReporte" readonly>
                                @error('noReporte') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aseguradoraId">Aseguradora</label>
                                <select class="form-control" id="aseguradoraId" wire:model="aseguradoraId" @if($origen != 'ASEGURADORA') disabled @endif>
                                    <option value="">Seleccione...</option>
                                    @foreach(\App\Models\Aseguradora::orderBy('nombre')->get() as $aseguradora)
                                        <option value="{{ $aseguradora->id }}">{{ $aseguradora->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('aseguradoraId') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tareaRealizar">Tarea a Realizar</label>
                        <textarea class="form-control" id="tareaRealizar" wire:model="tareaRealizar" rows="3"></textarea>
                        @error('tareaRealizar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancelar">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarEntrada">Guardar</button>
            </div>
        </div>
    </div>
</div> 