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
                        <input {{$inputDisabled}} wire:model="cliente.nombre" type="text" name="cliente.nombre" class="form-control"
                            required />
                        @error('cliente.nombre')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="cliente.abreviacion">Abreviacion</label>
                        <input {{$inputDisabled}} wire:model="cliente.abreviacion" style="text-transform: uppercase;" type="text" name="cliente.abreviacion" class="form-control"
                            required  minlength="2" maxlength="5"/>
                        @error('cliente.abreviacion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="cliente.rfc">RFC</label>
                        <input {{$inputDisabled}} wire:model="cliente.rfc" type="text" name="cliente.rfc" class="form-control"
                            required />
                        @error('cliente.rfc')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="cliente.razon_social">Razón Social</label>
                        <input {{$inputDisabled}} wire:model="cliente.razon_social" type="text" name="cliente.razon_social" class="form-control"
                            required />
                        @error('cliente.abreviarazon_socialcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.calle">Calle</label>
                        <input {{$inputDisabled}} wire:model="cliente.calle" type="text" name="cliente.calle" class="form-control"
                            required />
                        @error('cliente.calle')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label for="cliente.numero">Numero</label>
                        <input {{$inputDisabled}} wire:model="cliente.numero" type="text" name="cliente.numero" class="form-control"
                            required />
                        @error('cliente.numero')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.colonia">Colonia</label>
                        <input {{$inputDisabled}} wire:model="cliente.colonia" type="text" name="cliente.colonia" class="form-control"
                            required />
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
                        <input {{$inputDisabled}} wire:model="cliente.codigo_postal" type="text" name="cliente.codigo_postal" class="form-control"
                            required />
                        @error('cliente.codigo_postal')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.ciudad">Ciudad</label>
                        <input {{$inputDisabled}} wire:model="cliente.ciudad" type="text" name="cliente.ciudad" class="form-control"
                            required />
                        @error('cliente.ciudad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="cliente.estado">Estado</label>
                        <input {{$inputDisabled}} wire:model="cliente.estado" type="text" name="cliente.estado" class="form-control"
                            required />
                        @error('cliente.estado')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
            </div>

           
        </div>

        <div class="card-footer">
            @can('administrar-clientes')
            <button class="btn btn-primary" wire:click="save()"><i class="fas fa-save"></i> Guardar
                datos</button>
            @endcan
        </div>
    </div>
</div>
