
<div class="card-body p-2">

    @livewire('foto.mdl-upload-mobile-photos', ['model_id' => $this->model?->id, 'model_type' => 'App\\Models\\'.class_basename($this->model), 'storage_path' => $this->storage_path])


    @push('css')
        <link href="{{asset('vendor/lightbox-master/dist/ekko-lightbox.css')}}" rel="stylesheet">
        <style>
            .image-container {
                position: relative;
                display: inline-block;
            }
    
            .overlay-buttons {
                position: absolute;
                bottom: 5px;
                right: 5px;
                display: block;
                background: rgba(0, 0, 0, 0.5);
                padding: 2px;
                border-radius: 5px;
            }
    
            /* .image-container:hover .overlay-buttons {
                display: block;
            } */
    
            .overlay-buttons button {
                margin: 2px;
                /* Opcional: Ajusta estilos de botones si es necesario */
            }
        </style>
    @endpush

    @push('js')
        <script src="{{asset('vendor/lightbox-master/dist/ekko-lightbox.min.js')}}"></script>
        <script>
        $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true,
                    wrapping: false
                });
            });
        })
        </script>
    @endpush


    <div wire:loading.remove>
        @if (collect($images)->count() == 0)          
            <label class="btn btn-xs btn-warning m-1 p-2">
                <i class="fa fa-camera"></i>
                Subir fotos
                <input wire:model="images" accept="image/*" multiple style="display: none;" type="file" name="iptImage">
            </label>
            <button class="btn btn-xs btn-primary m-1 p-2" wire:click="$emit('createMobilePhotoToken')"><i class="fa fa-mobile"></i> Subir desde celular</button>
        @else
            <button class="btn btn-xs btn-primary m-1 p-2" wire:click="upload"><i class="fa fa-save"></i> Guardar</a>
            <button class="btn btn-xs btn-default m-1 p-2" wire:click="cancelar"><i class="fa fa-times"></i> Cancelar</a>
        @endif
    </div>

    <div wire:loading>
        <button class="btn btn-xs btn-primary m-1 p-2"><i class="fa fa-spin fa-spinner"></i> Espere...</a>
    </div>


    @error('images.*')
        <span class="error text-danger">{{ $message }}</span>
    @enderror

    @if ($images)
        <div class="row justify-content-center">
            @foreach ($images as $image)
                <div class="col-md-2 col-sm-6 m-2">
                    <center>
                        <img style="height: 210; width: 315px; object-fit:cover" src="{{ $image->temporaryUrl() }}" class="img-fluid mb-2" alt="image" />
                    </center>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row justify-content-center">
        @foreach ($this->model?->fotos ?? [] as $item)
            <div class="col-md-2 col-sm-6 m-2">
                <div class="image-container">
                    <a href="{{$item->url}}" data-toggle="lightbox" data-title="{{$item->fecha_creacion}}" data-gallery="gallery">
                        <img src="{{$item->location_thumb}}" class="img-fluid mb-2" alt="image"  />
                    </a>
                    <div class="overlay-buttons">
                        @php
                            $icon = $item->public ? 'users' : 'user';
                            $color = $item->public ? 'warning' : 'secondary';
                        @endphp
                        <button wire:click="downloadPhoto({{$item->id}})" class="btn btn-xs btn-default"><i class="fa fa-download"></i></button>
                        <button wire:click="changeScope({{$item->id}})" class="btn btn-xs btn-{{$color}}"><i class="fa fa-{{$icon}}"></i></button>
                        <button onclick="destroy({{$item->id}}, 'foto', 'removePhoto')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


</div>
