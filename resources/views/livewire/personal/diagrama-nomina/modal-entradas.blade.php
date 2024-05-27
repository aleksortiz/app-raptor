<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEntradas">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fecha: {{$this->selected_date}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if ($this->searchFolio)
                    <button wire:click="$set('searchFolio', false)" class="btn btn-xs btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Regresar</button>




                    <div class="form-group">

                        <div class="row mb-2">
                            <div class="col-9">
                                <label for="search">Buscar Folio</label>
                                <input type="text"  class="form-control" id="search" wire:keydown.enter="searchEntradas" wire:model.defer="entradaKeyWord" placeholder="Buscar">
                            </div>
                            <div class="col">

                                @if ($this->searchFolioOver)
                                    <center>
                                        <h3>Asignar Tiempo extra</h3>
                                    </center>
                                @else                              
                                    <label>Porcentaje Pendiente</label><br>
                                    <center>
                                        <h3>{{ 100 - $this->selected_personal?->getPorcentaje($this->selected_date)}} %</h3>
                                    </center>
                                @endif
                            </div>
                        </div>

                        @if(collect($this->entradas)->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Vehiculo</th>
                                        <th width="25%">{{$this->searchFolioOver ? "Pago Extra" : "Avance"}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->entradas as $item)
                                    <tr>
                                        <td><a href="/servicios/{{$item->id}}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-car"></i> {{ $item->folio_short }}</a></td>
                                        <td>{{ $item->vehiculo }}</td>
                                        <td>
                                            <input type="text" style="text-align: center" class="form-control" wire:keydown.enter="selectEntrada({{$item->id}})" wire:model="porcentajes.{{ $item->id }}" placeholder={{$this->searchFolioOver ? "Pago" : "Porcentaje"}} onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    @if(collect($this->entradas)->count() <= 0)                    
                        <div class="row">
                            <div class="form-group col-2">
                                <button class="btn btn-warning btn-md mb-2"><i class="fa fa-car"></i> TALLER</button>
                            </div>
                            <div class="form-group col-3">
                                <input type="text" style="text-align: center" class="form-control" wire:keydown.enter="selectEntrada({{0}})" wire:model="porcentajes.0" placeholder={{$this->searchFolioOver ? "Pago" : "Porcentaje"}} onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                            </div>
                        </div>
                    @endif

                @else

                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{$this->selected_personal?->nombre}}</h4>
                            <h5>Sueldo Diario <b>@money($this->selected_personal?->sueldo_diario)</b></h5>
                            <h5>Porcentaje asignado: <b>{{$this->selected_personal?->getPorcentaje($this->selected_date)}} %</b></h5>
                        </div>

                        <div class="col-md-2">
                            <div>
                                <br>
                                <br>
                                @if($this->selected_personal?->getPagos($this->selected_date)->count() == 0 )
                                    <button wire:click="ponerFalta" class="btn btn-xs btn-danger mb-3 "><i class="fa fa-times"></i> Poner Falta</button>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div>
                                <br>
                                <br>
                                <button wire:click="setOverTime" class="btn btn-xs btn-primary mb-3 "><i class="fa fa-clock"></i> Tiempo Extra</button>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div>
                                <br>
                                <br>
                                @if($this->selected_personal?->getPorcentaje($this->selected_date) < 100 )
                                    <button wire:click="setNormalTime" class="btn btn-xs btn-success mb-3 "><i class="fa fa-plus"></i> Asignar Folio</button>
                                @endif
                            </div>
                        </div>



                        
                    </div>


                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Vehiculo</th>
                                <th>Porcentaje</th>
                                <th>Pago</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->selected_personal?->getPagos($this->selected_date) ?? [] as $item)
                            <tr>
                                <td><a href="/servicios/{{$item->entrada_id}}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-car"></i> {{ $item->folio }}</a></td>
                                <td>{{ $item->entrada?->vehiculo ?? "TALLER" }}</td>
                                <td>
                                    @if ($item->porcentaje > 0)
                                        {{ $item->porcentaje }} %
                                    @else
                                        <button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> TIEMPO EXTRA</button>
                                    @endif
                                </td>
                                <td>@money($item->pago)</td>
                                <td><button onclick="confirm('¿Desea eliminar pago?','deletePay',{{$item->id}})" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
