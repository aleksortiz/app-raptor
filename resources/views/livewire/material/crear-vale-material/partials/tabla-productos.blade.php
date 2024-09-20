<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fa fa-ticket-alt"></i> Crear Vale de Material</h2>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <button wire:click="showMdlMateriales" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Agregar Material</button>
      </button>
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 85vh">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th>Código</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Entrada</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->listadoMaterial as $key => $item)
          <tr>
            <td><button onclick="destroy('{{ $loop->index }}','{{ $item['descripcion'] }}')" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
            <td>{{ $item['numero_parte'] }}</td>
            <td>{{ $item['descripcion'] }}</td>
            <td>
              <input style="width: 100px; text-align: center;" wire:model.lazy="listadoMaterial.{{$key}}.cantidad" onclick="this.select()" onkeypress="return event.charCode >= 46 && event.charCode <= 57"  type="text" class="form-control form-control-sm"/><br>
              @error('listadoMaterial.'.$key.'.cantidad') <span class="text-danger">Ingrese un valor valido</span> @enderror
            </td>
            <td>
              @if ($item['entrada_id'])
                <button wire:click="mdlSelectEntrada({{$key}})" class="btn btn-xs btn-success"><i class="fas fa-car"></i> {{$item['folio_entrada']}}</button>
              @else
                <button wire:click="mdlSelectEntrada({{$key}})" class="btn btn-xs btn-warning"><i class="fas fa-car"></i> Seleccione Entrada</button><br>
                @error('listadoMaterial.'.$key.'.entrada_id') <span class="text-danger">Seleccione Entrada</span> @enderror
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
