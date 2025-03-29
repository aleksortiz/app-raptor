<div x-data="{
    {{-- 'selected_id': @entangle('selected_id'),
    'selected_model': @entangle('selected_model'),
    'registrarFactura': function(id, model){
        this.selected_id = id;
        this.selected_model = model;
        window.Livewire.dispatch('showModal', '#mdlRegistroFactura');
    }, --}}
}">

    @section('content_header')
        <h1>Control de facturación</h1>
    @stop


    @include('livewire.control-facturacion.mdl-registro-factura')


    <h5><i class="fa fa-car"></i> Entradas Pendientes ({{ $entradas->count() }}) / <a href="/control-facturacion/facturas-registradas" ><i class="fa fa-file-alt"></i> Facturas Registradas</a></h5>

    <div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="search">Buscar</label>
                <input type="text" class="form-control" id="search" wire:model="search">
            </div>
        </div>
    </div>
    <table class="mt-3 table table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>No. Reporte</th>
                <th>Folio</th>
                <th>Vehículo</th>
                <th>Monto</th>
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entradas as $item)
                <tr>
                    <td>{{ $item->fecha_creacion }}</td>
                    <td>{{ $item->numero_reporte }}</td>
                    <td>{!! $item->folio_button !!}</td>
                    <td>{{ $item->vehiculo }}</td>
                    <td>@money($item->total_costos)</td>
                    <td><button wire:click="registrarFactura({{$item->id}}, 'ENTRADA')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Registrar factura</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- <h5><i class="fa fa-cube"></i> Refacciones ({{ $refacciones->count() }})</h5>
    <table class="mt-3 table table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Número de Reporte</th>
                <th>Descripción</th>
                <th>Proveedor</th>
                <th>Monto</th>
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($refacciones as $item)
                <tr>
                    <td>{{ $item->fecha_creacion }}</td>
                    <td>{{ $item->numero_reporte }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->proveedor->nombre }}</td>
                    <td>@money($item->precio)</td>
                    <td><button wire:click="registrarFactura({{$item->id}}, 'REFACCION')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Registrar factura</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <h5><i class="fa fa-shopping-cart"></i> Ventas a Facturar ({{ $ventas->count() }})</h5>
    <table class="mt-3 table table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Folio</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $item)
                <tr>
                    <td>{{ $item->fecha_creacion }}</td>
                    <td>{!! $item->id_paddy !!}</td>
                    <td>{{ $item->vehiculo }}</td>
                    <td>@money($item->mano_obra)</td>
                    <td><button wire:click="registrarFactura({{$item->id}}, 'VENTA')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Registrar factura</button></td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
</div>


