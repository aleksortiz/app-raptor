@section('title', __('Personal'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Personal</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row ml-4 mt-2">

                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Año</label>
                        <select wire:model="year" class="form-control" id="year">
                            @foreach (range(2021, $this->maxYear) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-1">
                    <div class="form-group">
                        <label for="keyWord">Semana</label>
                        <select wire:model="week" class="form-control" id="week">
                            @foreach (range(1, 52) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-hand-holding-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Nomina Operativa: </b></span>
                            <span class="info-box-number">@money($this->totalNominaOperativa)</span>
                        </div>

                    </div>
                </div>

                @can('admin-personal-administrativo')
                    <div class="col-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i
                                    class="fas fa-hand-holding-usd"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"><b>Nomina Administrativa: </b></span>
                                <span class="info-box-number">@money($this->totalNominaAdministrativa)</span>
                            </div>

                        </div>
                    </div>

                    <div class="col-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i
                                    class="fas fa-hand-holding-usd"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"><b>Total Nomina: </b></span>
                                <span class="info-box-number">@money($this->totalNomina)</span>
                            </div>

                        </div>
                    </div>
                @endcan

            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Personal</th>
                        @can('admin-personal-administrativo')
                            <th>Sueldo Sem.</th>
                            <th>Sueldo Acum.</th>
                        @endcan
                        <th>{{ $days[0] }}<br>{{ $dates[0] }}</th>
                        <th>{{ $days[1] }}<br>{{ $dates[1] }}</th>
                        <th>{{ $days[2] }}<br>{{ $dates[2] }}</th>
                        <th>{{ $days[3] }}<br>{{ $dates[3] }}</th>
                        <th>{{ $days[4] }}<br>{{ $dates[4] }}</th>
                        <th>{{ $days[5] }}<br>{{ $dates[5] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($personal as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nombre }}</td>
                            @can('admin-personal-administrativo')
                                <td>@money($row->sueldo)</td>
                                <td>
                                    @money($row->sueldo_acumulado($this->week, $this->year))
                                    @if ($row->percent_acumulado($this->week, $this->year) > 0)
                                        @php
                                            $color =
                                                $row->percent_acumulado($this->week, $this->year) > 100
                                                    ? 'text-danger'
                                                    : '';
                                        @endphp
                                        <small class="{{ $color }}">
                                            (@qty($row->percent_acumulado($this->week, $this->year)) %)
                                        </small>
                                    @endif
                                </td>
                            @endcan
                            @if ($row->administrativo)
                                <td>
                                    @if ($row->getPorcentaje($dates[0]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[0] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[0] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->getPorcentaje($dates[1]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[1] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[1] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->getPorcentaje($dates[2]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[2] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[2] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->getPorcentaje($dates[3]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[3] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[3] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->getPorcentaje($dates[4]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[4] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[4] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->getPorcentaje($dates[5]) >= 100)
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="removeAsistencia({{ $row->id }}, '{{ $dates[5] }}')" class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button wire:loading.attr="disabled" style="cursor: pointer;" wire:click="addAsistencia({{ $row->id }}, '{{ $dates[5] }}')" class="badge badge-secondary"><i class="fa fa-square"></i></button>
                                    @endif
                                </td>
                            @else
                                <td>
                                    @if (collect($row->getFalta($dates[0]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[0]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[0] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[0] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[0]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[0] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                                <td>
                                    @if (collect($row->getFalta($dates[1]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[1]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[1] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[1] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[1]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[1] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                                <td>
                                    @if (collect($row->getFalta($dates[2]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[2]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[2] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[2] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[2]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[2] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                                <td>
                                    @if (collect($row->getFalta($dates[3]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[3]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[3] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[3] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[3]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[3] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                                <td>
                                    @if (collect($row->getFalta($dates[4]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[4]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[4] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[4] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[4]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[4] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                                <td>
                                    @if (collect($row->getFalta($dates[5]))->count() == 0)
                                        @if ($row->getPorcentaje($dates[5]) >= 100)
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[5] }}')"
                                                class="badge badge-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span style="cursor: pointer;"
                                                wire:click="addPay({{ $row->id }}, '{{ $dates[5] }}')"
                                                class="badge badge-secondary"><i class="fa fa-plus"></i></span>
                                        @endif

                                        @php
                                            $pagosPorEntrada = collect($row->getPagos($dates[5]))->groupBy(
                                                'entrada_id',
                                            );
                                        @endphp
                                        @foreach ($pagosPorEntrada as $entrada_id => $pagos)
                                            @php
                                                $color = $pagos->contains('porcentaje', 0) ? 'warning' : 'primary';
                                                $pagoEntrada = $pagos->first();
                                            @endphp
                                            <a target="_blank" href="/servicios/{{ $entrada_id }}"
                                                class="badge badge-{{ $color }}">{{ $pagoEntrada->folio }}</a>
                                        @endforeach
                                    @else
                                        <span style="cursor: pointer"
                                            onclick="confirm('¿Desea eliminar falta?', 'quitarFalta', '{{ $row->id }}#{{ $dates[5] }}')"
                                            class="badge badge-danger"><i class="fa fa-times"></i> Falta</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @include('livewire.personal.diagrama-nomina.modal-entradas')
    @include('livewire.personal.diagrama-nomina.modal-materiales')
</div>
