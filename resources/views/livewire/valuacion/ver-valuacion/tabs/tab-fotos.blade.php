<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">

        {{-- <a href="/servicios/{{$this->entrada->id}}/subir-fotos" class="mb-3 btn btn-xs btn-warning"><i class="fa fa-edit"></i> Subir Fotos</a> --}}
        <div wire:loading.remove>
            <label class="btn btn-xs btn-warning mb-2 p-2">
                <i class="fa fa-camera"></i>
                Subir Foto
                <input wire:model="image" accept="image/*" style="display: none;" type="file" name="iptImage">
            </label>
        </div>
        <div wire:loading>
            <button disabled class="btn btn-xs btn-primary m-2 p-2"><i class="fa fa-spin fa-spinner"></i>
                Procesando...</a>
        </div>

        @error('image')
            <span class="error text-danger">{{ $message }}</span>
        @enderror

        @if ($this->valuacion->fotos->count() == 0)
            <div class="row">
                <div class="col">
                    <h2>No existen fotos para este folio</h2>
                </div>
            </div>
        @endif

        <div class="row">
            @foreach ($this->valuacion->fotos as $item)
                <div class="col-md-2 col-sm-6">
                    <center>
                        <a href="{{ $this->location_url }}/{{ $item->url }}" data-toggle="lightbox"
                            data-title="{{ $this->valuacion->vehiculo }}"
                            data-gallery="gallery">
                            <img style="max-height: 150px;" src="{{ $this->location_url }}/{{ $item->url }}"
                                class="img-fluid mb-2" alt="image" />
                        </a><br>
                        <button wire:click="downloadPhoto({{ $item->id }})" class="btn btn-xs btn-default"><i class="fa fa-download"></i> Descargar</button>
                        <button onclick="destroy({{ $item->id }}, 'Foto', 'removePhoto')" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                    </center>
                </div>
            @endforeach
        </div>

    </div>
</div>
