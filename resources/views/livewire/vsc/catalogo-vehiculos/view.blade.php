@section('title', 'Vehículos para la Venta')
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehículos para la Venta</h3>
        </div>
        <div class="card-body p-0">

            <div class="row p-2">

                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-car"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Valor de Inventario</b></span>
                            <span class="info-box-number">@money(0)</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-4">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Ventas</b></span>
                            <span class="info-box-number">@money(0)</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-4">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Utilidad</b></span>
                            <span class="info-box-number">@money(0)</span>
                        </div>
    
                    </div>
                </div>
    
                
            </div>

            <div class="row">
                <div class="col">
                    <button wire:click="mdl(0)" class="ml-3 mb-3 btn btn-xs btn-primary"><i class="fa fa-plus"></i> Agregar Vehículo</button>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Vehículo</th>
                                <th>Estatus</th>
                                <th>Fecha de Compra</th>
                                <th>Precio de Compra</th>
                                <th>Costos</th>
                                <th>Fecha de Venta</th>
                                <th>Precio de Venta</th>
                                <th>Utilidad</th>
                                <th>Utilidad (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiculos as $item)
                                <tr wire:click="mdl({{$item->id}})" style="cursor: pointer;">
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->purchase_date_format}}</td>
                                    <td>@money($item->purchase_price)</td>
                                    <td>@money($item->costs)</td>
                                    <td>{{$item->sale_date_format}}</td>
                                    <td>{{$item->sale_price_format}}</td>
                                    <td>{{$item->utility_format}}</td>
                                    <td>{{$item->utility_percentage}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
    {{ $vehiculos->links() }}

    @include('livewire.vsc.catalogo-vehiculos.modal')
</div>
