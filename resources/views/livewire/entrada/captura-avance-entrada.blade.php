<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>CARROCERIA</th>
                <th>PREPARADO</th>
                <th>PINTURA</th>
                <th>ARMADO</th>
                <th>TERMINADO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if (!$avance?->carroceria)
                        <label class="content-input">
                            <input wire:click="check('carroceria')" type="checkbox"/>
                            <i></i>
                        </label>
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></button></i> {{ $avance?->carroceria_format }}
                    @endif
                </td>
                <td>
                    @if (!$avance?->preparado)
                        @if ($avance?->carroceria)
                            <label class="content-input">
                                <input wire:click="check('preparado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE CARROCERIA
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></button></i> {{ $avance?->preparado_format }}
                    @endif
                </td>
                <td>
                    @if (!$avance?->pintura)
                        @if ($avance?->preparado)
                            <label class="content-input">
                                <input wire:click="check('pintura')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE PREPARADO
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></button></i> {{ $avance?->pintura_format }}
                    @endif
                </td>
                <td>
                    @if (!$avance?->armado)
                        @if ($avance?->pintura)
                            <label class="content-input">
                                <input wire:click="check('armado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE PINTURA
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></button></i> {{ $avance?->armado_format }}
                    @endif
                </td>
                <td>
                    @if (!$avance?->terminado)
                        @if ($avance?->armado)
                            <label class="content-input">
                                <input wire:click="check('terminado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE ARMADO
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></button></i> {{ $avance?->terminado_format }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>