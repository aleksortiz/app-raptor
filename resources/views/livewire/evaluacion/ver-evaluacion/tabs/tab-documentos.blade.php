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

                        @foreach ($this->evaluacion->documentos as $item)
                        <tr>
                            <td>
                                <div wire:loading.remove wire:target='eliminarDocumento'>
                                    <button class="btn btn-xs btn-danger" wire:click="$emit('confirm', '¿Desea eliminar documento?', '{{$item->name}}' ,'eliminarDocumento', {{$item->id}})"><i class="fa fa-trash-alt"></i></button>
                                </div>
                                <div wire:loading wire:target='eliminarDocumento'>
                                    <button class="btn btn-xs btn-danger" disabled wire:click="$emit('confirm', '¿Desea eliminar documento?', '{{$item->name}}' ,'eliminarDocumento', {{$item->id}})"><i class="fa fa-spin fa-spinner"></i></button>
                                </div>
                            </td>
                            <td>{{$item->fecha_creacion}}</td>
                            <td><b>{{$item->tipo}}</b></td>
                            <td>{{$item->name}}</td>
                            <td><button class="btn btn-xs btn-default" wire:click="descargarDocumento({{$item->id}})"><i class="fa fa-download"></i> Descargar</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>