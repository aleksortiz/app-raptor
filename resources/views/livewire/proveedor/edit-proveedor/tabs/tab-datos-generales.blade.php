<div class="tab-pane {{ $activeTab == 1 ? 'active' : '' }}" id="tab_1">
    <div class="card m-0" style="min-height: 65vh;">
        <div class="card-body">

            @php
                $inputDisabled = auth()->user()->can('administrar-proveedores') ? '' : 'disabled';
            @endphp

            <div class="form-row">
                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="proveedor.nombre">Nombre</label>
                        <input {{$inputDisabled}} wire:model="proveedor.nombre" type="text" class="form-control" />                            


                        @error('proveedor.nombre')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="proveedor.rfc">RFC</label>
                        <input {{$inputDisabled}} wire:model="proveedor.rfc" type="text" class="form-control" />

                        @error('proveedor.rfc')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="proveedor.razon_social">Razón Social</label>
                        <input {{$inputDisabled}} wire:model="proveedor.razon_social" type="text" class="form-control" />

                        @error('proveedor.abreviarazon_socialcion')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="proveedor.calle">Calle</label>
                        <input {{$inputDisabled}} wire:model="proveedor.calle" type="text" class="form-control" />

                        @error('proveedor.calle')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label for="proveedor.numero">Numero</label>
                        <input {{$inputDisabled}} wire:model="proveedor.numero" type="text" class="form-control" />

                        @error('proveedor.numero')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="proveedor.colonia">Colonia</label>
                        <input {{$inputDisabled}} wire:model="proveedor.colonia" type="text" class="form-control" />
                        
                        @error('proveedor.colonia')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label for="proveedor.codigo_postal">Código Postal</label>
                        <input {{$inputDisabled}} wire:model="proveedor.codigo_postal" type="text" class="form-control" />

                        @error('proveedor.codigo_postal')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="proveedor.ciudad">Ciudad</label>
                        <input {{$inputDisabled}} wire:model="proveedor.ciudad" type="text" class="form-control" />

                        @error('proveedor.ciudad')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="proveedor.estado">Estado</label>
                        <input {{$inputDisabled}} wire:model="proveedor.estado" type="text" class="form-control" />

                        @error('proveedor.estado')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
            </div>

           
        </div>

        <div class="card-footer">
            @can('administrar-proveedores')
            <button class="btn btn-primary" wire:click="save()"><i class="fas fa-save"></i> Guardar
                datos</button>
            @endcan
        </div>
    </div>
</div>
