<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        <div class="p-3">
            <div class="form-group">
                <label for="tarea_realizar">Tarea a Realizar</label>
                <div class="input-group">
                    <textarea class="form-control text-uppercase" 
                            wire:model.defer="entrada.tarea_realizar" 
                            rows="3"
                            style="resize: none;"
                            id="tarea_realizar"
                            oninput="checkChanges(this)"
                            placeholder="DESCRIBE LA TAREA A REALIZAR"></textarea>
                    <div class="input-group-append" id="btn-guardar-tarea" style="display: none;">
                        <button class="btn btn-primary h-100" wire:click="guardarTareaRealizar">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-xs m-2" wire:click="$emitTo('entrada.ver-entrada.modals.crear-asignacion', 'showModal', {{ $entrada->id }})">
            <i class="fas fa-plus"></i> Nueva Asignación
        </button>

        <div class="row" wire:poll.10s>
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 20%">Personal</th>
                            <th>Descripción del Trabajo</th>
                            <th style="width: 15%">Fecha Asignación</th>
                            <th style="width: 15%">Fecha Realizado</th>
                            <th style="width: 10%">Estado</th>
                            <th style="width: 10%">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entrada->asignaciones()->with('personal')->orderBy('created_at', 'desc')->get() as $asignacion)
                            <tr wire:key="asignacion-{{ $asignacion->id }}">
                                <td>{{ $asignacion->personal->nombre }}</td>
                                <td>{{ $asignacion->descripcion_trabajo }}</td>
                                <td class="text-center">{{ $asignacion->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">{{ $asignacion->fecha_realizado ? $asignacion->fecha_realizado->format('d/m/Y H:i') : 'Pendiente' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $asignacion->estado === 'completado' ? 'success' : ($asignacion->estado === 'en_proceso' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $asignacion->estado)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-info" wire:click="$emitTo('entrada.ver-entrada.modals.editar-asignacion', 'showModal', {{ $asignacion->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger" onclick="confirmarEliminacion({{ $asignacion->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay asignaciones registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('eliminarAsignacion', id);
        }
    });
}

function checkChanges(textarea) {
    const btnGuardar = document.getElementById('btn-guardar-tarea');
    const originalValue = @this.entrada.tarea_realizar || '';
    const currentValue = textarea.value;
    
    if (currentValue !== originalValue) {
        btnGuardar.style.display = 'block';
    } else {
        btnGuardar.style.display = 'none';
    }
}

// Inicializar el estado del botón cuando se carga la página
document.addEventListener('livewire:load', function () {
    const textarea = document.getElementById('tarea_realizar');
    if (textarea) {
        checkChanges(textarea);
    }
});
</script>
@endpush
