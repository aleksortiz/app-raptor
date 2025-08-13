<div class="tab-pane {{ $activeTab == 1 ? 'active' : '' }}" id="tab_1">
    <div class="card m-0" style="min-height: 65vh;">
        <div class="card-body">
            @php
                $inputDisabled = auth()->user()->can('administrar-clientes') ? '' : 'disabled';
            @endphp

            <div class="form-row">
                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="cliente.nombre">Nombre</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.nombre" type="text" name="cliente.nombre" class="form-control" required />
                        @error('cliente.nombre')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="cliente.telefono">Teléfono</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.telefono" type="text" name="cliente.telefono" class="form-control" />
                        @error('cliente.telefono')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="cliente.rfc">RFC</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.rfc" type="text" name="cliente.rfc" class="form-control" />
                        @error('cliente.rfc')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="cliente.razon_social">Razón Social</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.razon_social" type="text" name="cliente.razon_social" class="form-control" />
                        @error('cliente.razon_social')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.calle">Calle</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.calle" type="text" name="cliente.calle" class="form-control" />
                        @error('cliente.calle')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label for="cliente.numero">Numero</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.numero" type="text" name="cliente.numero" class="form-control" />
                        @error('cliente.numero')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.colonia">Colonia</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.colonia" type="text" name="cliente.colonia" class="form-control" />
                        @error('cliente.colonia')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label for="cliente.codigo_postal">Código Postal</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.codigo_postal" type="text" name="cliente.codigo_postal" class="form-control" />
                        @error('cliente.codigo_postal')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.ciudad">Ciudad</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.ciudad" type="text" name="cliente.ciudad" class="form-control" />
                        @error('cliente.ciudad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.estado">Estado</label>
                        <input {{$inputDisabled}} wire:model.defer="cliente.estado" type="text" name="cliente.estado" class="form-control" />
                        @error('cliente.estado')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
            </div>

           
        </div>

        <div class="card-footer">
            @can('administrar-clientes')
            <button class="btn btn-primary" wire:click="save()"><i class="fas fa-save"></i> Guardar datos</button>
            @endcan
        </div>
    </div>
</div> 