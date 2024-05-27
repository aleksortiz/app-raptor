<div class="m-3">
    

    <div class="row">
        <div class="col">
            <a href="/proveedores/{{$this->orden->proveedor->id}}" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-truck"></i> Ver Proveedor</a>
            <h2>{{$this->orden->proveedor->nombre}}</h2>
            @if ($this->orden->proveedor->rfc)
                <h5>RFC: {{$this->orden->proveedor->rfc}}</h5>
            @endif
            @if ($this->orden->proveedor->razon_social)
                <h5>Razón Social: {{$this->orden->proveedor->razon_social}}</h5>
            @endif
            @if ($this->orden->proveedor->direccion)
                <h5>Dirección: {{$this->orden->proveedor->direccion}}</h5>
            @endif
        </div>
    </div>


    <br>
    <div class="row">
        <div class="col">
            <h4>Contactos</h4>
            <div class="mb-2">
                <livewire:contacto.common.btn-select-contactos :provider="$this->orden->proveedor" :model="$this->orden" :wire:key="$this->orden->id" />
                @if ($this->orden->contactos->count() > 0)
                    <button wire:click="mdlCorreo" class="btn btn-xs btn-warning"><i class="fa fa-envelope"></i> Enviar orden</button>
                @endif
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Departamento</th>
                        <th>Telefonos</th>
                        {{-- <th>Envios</th> --}}
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->orden->contactos as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->prefijo_nombre}}</td>
                        <td>{{$item->correo}}</td>
                        <td>{{$item->departamento}}</td>
                        <td>
                            <livewire:contacto.common.btn-telefonos :contacto="$item" :wire:key="'contacto-tel-'.$item->id">
                        </td>
                        {{-- <td><button wire:click="test" class="btn btn-xs btn-warning"><i class="fa fa-envelope"></i></button></td> --}}
                        <td>
                            @if (!$loop->first)
                                <button wire:click="changeOrderContacto({{$item->id}}, -1)" class="btn btn-xs btn-primary"><i class="fas fa-arrow-up"></i></button>
                            @endif
                            @if (!$loop->last)
                                <button wire:click="changeOrderContacto({{$item->id}}, 1)" class="btn btn-xs btn-primary"><i class="fas fa-arrow-down"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>