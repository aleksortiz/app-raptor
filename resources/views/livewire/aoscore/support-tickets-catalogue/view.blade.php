@section('title', __('Soporte Técnico'))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tickets de Soporte</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">

            @canany(['tickets-soporte'])
                <button class="btn btn-xs btn-success m-2" wire:click="mdlCreate"><i class="fas fa-ticket-alt"></i> Crear Ticket</button>
            @endcanany

            <table class="table table-hover projects">

                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id_paddy }}</td>
                            <td>{{ $row->fecha_creacion }}</td>
                            <td>{{ $row->user_name }}</td>
                            <td>{{ $row->type }}</td>
                            <td><button class="btn btn-xs btn-{{$row->status_color}}">{{ $row->status }}</button></td>
                            <td><a href="/aos/tickets-soporte/{{ $row->id }}" class="btn btn-xs btn-warning"><i class="fa fa-ticket-alt"></i> Ver ticket</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- /.card-body -->
    </div>
    {{ $data->links() }}

    @include('livewire.aoscore.support-tickets-catalogue.modal')
</div>
