<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>MECANICA</th>
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
                    @if ($avance?->carroceria)
                        <span class="text-muted">OMITIDO</span>
                    @elseif (!$avance?->mecanica)
                        <label class="content-input">
                            <input wire:click="check('mecanica')" type="checkbox"/>
                            <i></i>
                        </label>
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->mecanica_format }}
                    @endif
                </td>
                <td>
                    @if ($avance?->mecanica)
                        <span class="text-muted">OMITIDO</span>
                    @elseif (!$avance?->carroceria)
                        <label class="content-input">
                            <input wire:click="check('carroceria')" type="checkbox"/>
                            <i></i>
                        </label>
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->carroceria_format }}
                    @endif
                </td>
                <td>
                    @if ($avance?->mecanica)
                        <span class="text-muted">OMITIDO</span>
                    @elseif (!$avance?->preparado)
                        @if ($avance?->carroceria)
                            <label class="content-input">
                                <input wire:click="check('preparado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE CARROCERIA
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->preparado_format }}
                    @endif
                </td>
                <td>
                    @if ($avance?->mecanica)
                        <span class="text-muted">OMITIDO</span>
                    @elseif (!$avance?->pintura)
                        @if ($avance?->preparado)
                            <label class="content-input">
                                <input wire:click="check('pintura')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE PREPARADO
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->pintura_format }}
                    @endif
                </td>
                <td>
                    @if ($avance?->mecanica)
                        <span class="text-muted">OMITIDO</span>
                    @elseif (!$avance?->armado)
                        @if ($avance?->pintura)
                            <label class="content-input">
                                <input wire:click="check('armado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE PINTURA
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->armado_format }}
                    @endif
                </td>
                <td>
                    @if (!$avance?->terminado)
                        @if ($avance?->mecanica || $avance?->armado)
                            <label class="content-input">
                                <input wire:click="check('terminado')" type="checkbox"/>
                                <i></i>
                            </label>
                        @else
                            PENDIENTE MECANICA O ARMADO
                        @endif
                    @else
                        <button class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button> {{ $avance?->terminado_format }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>