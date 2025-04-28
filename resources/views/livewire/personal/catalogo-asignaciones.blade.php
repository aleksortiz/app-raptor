@extends('adminlte::page')

@section('content')
    <div class="pt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3>Catálogo de Asignaciones</h3>
                    </div>
                    <div class="col-6 text-right">
                        <div class="form-inline float-right">
                            <div class="form-group mr-2">
                                <select wire:model="semana" class="form-control">
                                    @foreach($semanas as $key => $sem)
                                        <option value="{{ $key }}">{{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select wire:model="estado" class="form-control">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="completado">Completado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Personal</th>
                                <th>Entrada</th>
                                <th>Descripción del Trabajo</th>
                                <th>Fecha Asignación</th>
                                <th>Fecha Realizado</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asignaciones as $asignacion)
                                <tr>
                                    <td>{{ $asignacion->personal->nombre_completo }}</td>
                                    <td>
                                        <a href="{{ route('entradas.ver', $asignacion->entrada_id) }}" target="_blank">
                                            {{ $asignacion->entrada->folio_short }}
                                        </a>
                                    </td>
                                    <td>{{ $asignacion->descripcion_trabajo }}</td>
                                    <td>{{ $asignacion->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $asignacion->fecha_realizado ? $asignacion->fecha_realizado->format('d/m/Y H:i') : 'Pendiente' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $asignacion->estado === 'completado' ? 'success' : ($asignacion->estado === 'en_proceso' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $asignacion->estado)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info" wire:click="$emit('showModal', 'entrada.ver-entrada.modals.mdl-editar-asignacion', {{ $asignacion->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay asignaciones registradas en esta semana</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $asignaciones->links() }}
                </div>
            </div>
        </div>
    </div>

    @livewire('entrada.ver-entrada.modals.editar-asignacion')
@endsection
