<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body p-0">
        <button data-toggle="modal" data-target="#mdlUploadDocument" wire:click="$set('tipoDocumento', '')" class="m-2 btn btn-xs btn-primary"><i class="fa fa-plus"></i> Agregar Documento</button>
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DOCS OBLIGATORIOS --}}
                        @foreach ($this->required_docs as $item)
                        <tr>
                            <td></td>
                            <td>N/A</td>
                            <td><b>{{$item}}</b></td>
                            <td><span class="badge badge-pill badge-warning">PENDIENTE</span></td>
                            <td><button data-toggle="modal" data-target="#mdlUploadDocument" wire:click="$set('tipoDocumento', '{{$item}}')" class="btn btn-xs btn-primary"><i class="fa fa-upload"></i> Subir Documento</button></td>
                        </tr>
                        @endforeach

                        {{-- DOCS SUBIDOS --}}
                        @foreach ($entrada->documentos as $doc)
                        <tr>
                            <td></td>
                            <td>{{$doc->created_at->format('d/m/Y H:i')}}</td>
                            <td><b>{{$doc->tipo}}</b></td>
                            <td>{{$doc->name}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('entrada.download-document', $doc->id)}}" class="btn btn-xs btn-info"><i class="fa fa-download"></i></a>
                                    <button wire:click="eliminarDocumento({{$doc->id}})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('livewire.entrada.ver-entrada.modals.mdl-upload-doc') 