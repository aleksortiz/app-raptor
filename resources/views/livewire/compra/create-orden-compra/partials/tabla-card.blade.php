<div class="card" style="min-height: 85vh;">
    <div class="card-header">
        <h2 class="card-title font-weight-bold"><i class="fas fa-shopping-cart"></i>
            @if ($this->po->proyecto_id)
                Proyecto <a href="/proyectos/{{$this->po->proyecto_id}}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-rocket"></i> #{{$this->po->proyecto->id_paddy}}</a> {{$this->po->proyecto->titulo}}
            @else
                Crear orden de compra
            @endif
        </h2>
        <div class="float-right">

            <div wire:loading>
                <button class="btn btn-secondary btn-sm"><i class='fa fa-spin fa-spinner'></i> Cargando...</button>
            </div>
            <div wire:loading.remove>
                @if (!$this->po->proyecto_id)
                    <livewire:proyecto.common.btn-select-proyecto />
                @else

                    @if ($this->po->emergente || $this->po->conceptos->count() == 0)
                        <button wire:click="addConcepto" class="btn btn-sm btn-secondary"><i class="fas fa-plus"></i> Agregar Concepto</button>
                    @endif

                    @if (!$this->po->emergente || $this->po->conceptos->count() == 0)
                        <livewire:compra.common.btn-select-solicitudes-compra :proyecto="$this->po->proyecto" />
                    @endif


                    @if ($this->po->emergente && $this->po->conceptos->count() > 0)
                        <button class="btn btn-sm btn-danger"><i class="fas fa-exclamation-triangle"></i> Orden Emergente</button>
                    @endif
                @endif
            </div>

            
        </div>

    </div>
    <div class="card-body p-0">
        <table class="table table-hover projects">
            <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    {{-- <th>S.C.</th> --}}
                    <th>Número de Parte</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Sub-Total</th>
                </tr>
        </thead>
            <tbody>
                @foreach ($this->po->conceptos as $item)
                    @php
                        $em = $item->presupuesto_material_id == null;
                    @endphp
                    <tr>
                        <td><button wire:click="removeConcepto({{$item->id}})" class='btn btn-xs btn-danger'><i class="fa fa-trash"></i></button></td>
                        <td>{{$loop->iteration}}</td>
                        {{-- <td><button class="btn btn-sm btn-warning"><b>{{$item->solicitud_compra_conceptos->groupBy('solicitud_compra_id')->count()}}</b></button></td> --}}
                        @if($this->po->emergente)
                            <td>
                                <input class="form-control form-control-sm" type="text" wire:model.lazy="conceptos.{{$loop->index}}.numero_parte" />
                                @error("conceptos.{$loop->index}.numero_parte") <span class="error text-danger">{{$message}}</span> @enderror
                            </td>
                            <td><input class="form-control form-control-sm" type="text" wire:model.lazy="conceptos.{{$loop->index}}.descripcion" /></td>
                            <td><input class="form-control form-control-sm" style="width: 100px; text-align: center" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.lazy="conceptos.{{$loop->index}}.cantidad" /></td>
                        @else
                            <td>{{$item->numero_parte}}</td>
                            <td>{{$item->descripcion}}</td>
                            <td>{{$item->cantidad}}</td>
                        @endif
                        <td><input class="form-control form-control-sm" style="width: 100px; text-align: center" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.lazy="conceptos.{{$loop->index}}.precio" /></td>
                        <td align="right">@money($item->subtotal)</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
