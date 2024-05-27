<div class="card" style="min-height: 85vh;">
    <div class="card-header">
        <h2 class="card-title font-weight-bold">Totales</h2>
        <div class="float-right">
            @if ($this->po->id)
                <button wire:click="cancelPO" class="btn btn-danger btn-xs"><i class='fa fa-times'></i> Cancelar O.C.</button>
            @endif
        </div>
    </div>
    <div class="card-body p-2">
        <div class="row m-0">
            <div class="col"><h5>SUBTOTAL:</h5></div>
            <div class="col">
                <div class="float-right">
                    <h5>@money($this->po->subtotal)</h5>
                </div>
            </div>
        </div>
        <hr class="m-2">
        <div class="row m-0">
            <div class="col">
                <h5>IVA:</h5>
                @if ($this->po->id)    
                    <select wire:model="po.tasa_iva" wire:change="save" class="form-control form-control-sm">
                        <option value="8.00">8.00%</option>
                        <option value="16.00">16.00%</option>
                    </select>
                @endif
            </div>
            <div class="col">
                <div class="float-right">
                    <h5>@money($this->po->iva)</h5>
                </div>
            </div>
        </div>
        <hr class="m-2">
        <div class="row m-0">
            <div class="col"><h5>TOTAL:</h5></div>
            <div class="col">
                <div class="float-right">
                    <h5>@money($this->po->total)</h5>
                </div>
            </div>
        </div>
        <hr class="m-2">
        @if ($this->po->proyecto_id)
            <div class="row m-0">
                <div class="col">
                    <livewire:proveedor.common.btn-select-proveedor />
                </div>
            </div>
            <hr>

            @if ($this->po->proveedor_id)                
                <div class="row m-0">
                <div class="col">
                    <label>Proveedor:</label>
                    <h5>{{$this->po->proveedor->nombre}}</h5>
                    <label>Dirección:</label>
                    <h5>{{$this->po->proveedor->direccion}}</h5>
                    <br>

                    @if ($this->po->conceptos->count() > 0)
                        <center>
                            <button onclick="confirm('Generar Orden de Compra', 'createPO')" class="btn btn-success"><i class="fa fa-shopping-cart"></i> GENERAR ORDEN DE COMPRA</button>
                        </center>
                        <br>
                    @endif

                </div>
                </div>
            @endif

            <label>Notas</label>
            <textarea rows="4" wire:model.lazy="po.notas" style="resize: none" class="form-control"></textarea>
        @endif
    </div>
</div>
