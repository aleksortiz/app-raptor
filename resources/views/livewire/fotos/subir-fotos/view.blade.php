<div class="card-body p-2">

    <div wire:loading.remove>
        <label class="btn btn-sm btn-warning m-1 p-2">
            <i class="fa fa-camera"></i>
            Subir Foto
            <input wire:model="image" accept="image/*" style="display: none;" type="file" name="iptImage">
        </label>
    </div>
    <div wire:loading>
        <button disabled class="btn btn-md btn-primary m-1 p-2"><i class="fa fa-spin fa-spinner"></i> Subiendo Foto...</a>
    </div>

    @error('image')
        <span class="error text-danger">{{ $message }}</span>
    @enderror

    <div class="row">
        @foreach ($this->model->fotos as $item)
            <div class="col-md-2 col-sm-6 m-2">
                <center>
                <a href="{{$location_url}}/{{$item->url}}" data-toggle="lightbox" data-title="{{$item->fecha_creacion}}" data-gallery="gallery">
                    <img style="height: 140px; width: 210px; object-fit:cover" src="{{$location_url}}/{{$item->url}}" class="img-fluid mb-2" alt="image"  />
                </a><br>
                <button onclick="destroy({{$item->id}}, 'Foto', 'removePhoto')" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                <button wire:click="downloadPhoto({{$item->id}})" class="btn btn-xs btn-default"><i class="fa fa-download"></i> Descarga</button>
                </center>
            </div>
        @endforeach
    </div>

    {{-- <figure wire:ignore>
        <img style="height: 200px;" id="imgPreview" src="{{asset('/images/logo.png')}}">
    </figure> --}}
</div>
