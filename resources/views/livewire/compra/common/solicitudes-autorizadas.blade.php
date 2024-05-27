<div>
    @php
        $selected = collect($this->selectedSolicitudes)->filter(function($item){
            return $item['selected'];
        })->count() > 0;
    @endphp

    @if ($selected)
        <button onclick="confirm('Crear orden de compra', 'createSolicitudCompra')" class="btn btn-xs btn-success m-2"><i class="fas fa-plus"></i> Crear orden de compra</button>
    @endif


    <table class="table table-hover">
        <thead>
            <tr>
                <th>Selecc.</th>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Proyecto</th>
                <th>Requisitor</th>
                <th>Autorizado Por:</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($solicitudes as $item)
            <tr>
                <td>
                    <label class="content-input">
                        <input wire:model="selectedSolicitudes.{{$item->id}}.selected" type="checkbox" />
                        <i></i>
                    </label>
                </td>
                <td>{{$item->id_paddy}}</td>
                <td>{{$item->fecha_creacion}}</td>
                <td>{{$item->proyecto->titulo}}</td>
                <td>{{$item->user->name}}</td>
                <td>{{$item->autorizado_por->name }}</td>
                <td><livewire:compra.common.btn-detalles :solicitud="$item" :wire:key="$item->id" /></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
