<div>
  @if ($valuacion->pago_danos)
    <div class="alert alert-danger text-center" style="font-weight: bold; font-size: 18px;">
      <i class="fa fa-exclamation-triangle"></i> ¡ATENCIÓN! ESTA VALUACIÓN TIENE PAGO DE DAÑOS ACTIVO <i class="fa fa-exclamation-triangle"></i>
    </div>
  @endif

  @if (false)
    <button class="btn btn-primary btn-md" wire:click="crearPresupuesto"><i class="fa fa-file-alt"></i> Crear Presupuesto</button>
    <br><br>
    <h3>-- Sin Presupuestos --</h3>
  @else


    <div class="row">

      <div class="col-6">
        <h3><i class="fa fa-file-alt"></i> Presupuesto</h3>
        @if ($this->edit_mode)
        <button class="btn btn-primary btn-xs" wire:click="savePresupuesto"><i class="fa fa-save"></i> Guardar</button>
          <button class="btn btn-primary btn-xs" wire:click="addConcepto"><i class="fa fa-plus"></i> Concepto</button>
        @else
          <button class="btn btn-warning btn-xs" wire:click="$set('edit_mode', true)"><i class="fa fa-edit"></i>  Editar</button>
          <a class="btn btn-success btn-xs" href="/presupuestos/{{$this->presupuesto->id}}/excel?pago_danos={{$this->valuacion->pago_danos}}" ><i class="fa fa-file-excel"></i> Descargar Excel</a>
          <a class="btn btn-danger btn-xs" href="/presupuestos/{{$this->presupuesto->id}}/pdf?pago_danos={{$this->valuacion->pago_danos}}" ><i class="fa fa-file-pdf"></i> Descargar PDF</a>
        @endif
      </div>





      @if ($this->edit_mode)
        <div class="col">
          <div class="form-group">
            <label for="concepto">IVA</label>
            <select class="form-control" id="tasa_iva" wire:model="tasa_iva">
              <option value="0">0%</option>
              <option value="0.08">8%</option>
              <option value="0.16">16%</option>
            </select>
          </div>
        </div>
        
        <div class="col">
          <div class="form-group">
            <label for="mecanica">Mecánica</label>
            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" type="text" class="form-control" id="mecanica" wire:model.defer="mecanica">
            @error('mecanica') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="col">
          <div class="form-group">
            <label for="hojalateria">Hojalatería</label>
            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" type="text" class="form-control" id="hojalateria" wire:model.defer="hojalateria">
            @error('hojalateria') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="col">
          <div class="form-group">
            <label for="pintura">Pintura</label>
            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" type="text" class="form-control" id="pintura" wire:model.defer="pintura">
            @error('pintura') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="col">
          <div class="form-group">
            <label for="armado">Armado</label>
            <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" maxlength="2" style="text-align: center;" type="text" class="form-control" id="armado" wire:model.defer="armado">
            @error('armado') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>
      @else
        <div class="col-6">
          <div class="row">

            <div class="col">
              <div class="form-group">
                <label for="iva">IVA</label>
                <p class="form-control-static" style="text-align: center;">{{ $tasa_iva * 100 }}%</p>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="mecanica">Mecánica</label>
                <p class="form-control-static" style="text-align: center;">{{ $mecanica }}</p>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="hojalateria">Hojalatería</label>
                <p class="form-control-static" style="text-align: center;">{{ $hojalateria }}</p>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="pintura">Pintura</label>
                <p class="form-control-static" style="text-align: center;">{{ $pintura }}</p>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="armado">Armado</label>
                <p class="form-control-static" style="text-align: center;">{{ $armado }}</p>
              </div>
            </div>
          </div>
        </div>
      @endif


    </div>


    <table class="table table-hover">
      <thead>
        <tr>
          @if ($this->edit_mode)
            <th></th>
          @endif
          <th>Nomenclatura</th>
          <th>Cantidad</th>
          <th width="30%">Descripcion</th>
          <th>Mano de Obra</th>
          <th>Refacciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->presupuesto?->conceptos ?? [] as $item)
          <tr>
            @if ($this->edit_mode)
              <td><button class="btn btn-danger btn-xs" onclick="confirm('Eliminar Concepto', 'eliminarConcepto', {{$item->id}})" ><i class="fa fa-times"></i></button></td>
              <td>
                <select class="form-control" wire:model.defer="presupuestoConceptos.{{$loop->index}}.nomenclatura">
                  <option>--Seleccione--</option>
                  <option value="I-REPARAR">I-REPARAR</option>
                  <option value="E-REEMPLAZO">E-REEMPLAZO</option>
                  <option value="LE-PINTURA REEMPLAZO">LE-PINT. REEMPLAZO</option>
                  <option value="V-ALINEACION">V-ALINEACION</option>
                  <option value="N-DESMONTAJE">N-DESMONTAJE</option>
                </select>
                @error('presupuestoConceptos.'.$loop->index.'.nomenclatura') <span class="text-danger">{{ $message }}</span> @enderror
              </td>
              <td>
                <input style="text-align: center" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" wire:model.defer="presupuestoConceptos.{{$loop->index}}.cantidad">
                @error('presupuestoConceptos.'.$loop->index.'.cantidad') <span class="text-danger">{{ $message }}</span> @enderror
              </td>
              <td>
                <input type="text" class="form-control" wire:model.defer="presupuestoConceptos.{{$loop->index}}.descripcion">
                @error('presupuestoConceptos.'.$loop->index.'.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
              </td>
              <td>
                <input style="text-align: right" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" wire:model.defer="presupuestoConceptos.{{$loop->index}}.mano_obra">
                @error('presupuestoConceptos.'.$loop->index.'.mano_obra') <span class="text-danger">{{ $message }}</span> @enderror
              </td>
              <td>
                <input style="text-align: right" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control" wire:model.defer="presupuestoConceptos.{{$loop->index}}.refacciones">
                @error('presupuestoConceptos.'.$loop->index.'.refacciones') <span class="text-danger">{{ $message }}</span> @enderror
              </td>
            @else
              <td>{{$item->nomenclatura}}</td>
              <td>{{$item->cantidad}}</td>
              <td>{{$item->descripcion}}</td>
              <td>{{$item->mano_obra}}</td>
              <td>{{$item->refacciones}}</td>
            @endif
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          @if ($this->edit_mode)
            <td colspan="{{ $this->edit_mode ? 4 : 3 }}"></td>
          @else
            <td colspan="3"></td>
          @endif
          <td class="text-right"><strong>Subtotal:</strong></td>
          <td class="text-right">${{ number_format($this->presupuesto?->subtotal ?? 0, 2) }}</td>
        </tr>
        <tr>
          @if ($this->edit_mode)
            <td colspan="{{ $this->edit_mode ? 4 : 3 }}"></td>
          @else
            <td colspan="3"></td>
          @endif
          <td class="text-right"><strong>IVA ({{ $tasa_iva * 100 }}%):</strong></td>
          <td class="text-right">${{ number_format($this->presupuesto?->iva ?? 0, 2) }}</td>
        </tr>
        <tr>
          @if ($this->edit_mode)
            <td colspan="{{ $this->edit_mode ? 4 : 3 }}"></td>
          @else
            <td colspan="3"></td>
          @endif
          <td class="text-right"><strong>Total:</strong></td>
          <td class="text-right">${{ number_format($this->presupuesto?->total ?? 0, 2) }}</td>
        </tr>
      </tfoot>
    </table>
  @endif
</div>
