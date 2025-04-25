<?php

namespace App\Http\Livewire\Fotos;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class SubirFotosV3 extends Component
{
    use WithFileUploads, PhotoTrait;

    public $model;
    
    public $storage_path;
    public $redirectMode;
    public $images = [];

    protected $listeners = [
        'removePhoto'
    ];

    protected $rules = [
        'images.*' => 'image|max:10240',
    ];

    protected $queryString = ['redirectMode'];

    public function mount($model_id, $model_type, $storage_path){
        $this->model = $model_type::find($model_id);
        $this->storage_path = $storage_path;
    }

    public function render()
    {
        return view('livewire.fotos.subir-fotos.subir-fotos-v3.view');
    }


    public function cancelar(){
        $this->images = [];
    }

    
    public function uploadXXX()
    {
        $this->validate();
    
        foreach ($this->images as $image) {
        
            $fileName = $image->store($this->storage_path, 's3');
    
            if ($fileName) {
                $bucket = env('AWS_BUCKET_URL');
    
                $thumbImage = Image::make($image)
                ->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio(); // Mantiene la proporción
                    $constraint->upsize(); // No aumenta el tamaño si es menor a 1200px
                })
                ->encode('jpg', 80); 


                $thumbFileName = $this->storage_path . '/thumbs/' . basename($fileName);
                Storage::disk('s3')->put($thumbFileName, (string) $thumbImage->encode('jpg', 90), 'public');

                if(str_starts_with($thumbFileName, '/')){
                    $thumbFileName = substr($thumbFileName, 1);
                }
                if(str_starts_with($fileName, '/')){
                    $fileName = substr($fileName, 1);
                }
    
                $foto = new Foto([
                    'model_id' => $this->model->id,
                    'model_type' => get_class($this->model),
                    'url' => $bucket . $fileName,
                    'url_thumb' => $bucket . $thumbFileName,
                ]);
    
                $this->model->fotos()->save($foto);
                $this->model->load('fotos');
            }
        }
    
        $this->images = [];
        $this->emit('ok', 'Se han subido fotos');
    }

    public function upload()
    {
        $this->validate();

        foreach ($this->images as $image) {
            // 1. Comprimir como WhatsApp (máximo 1600px, calidad 80)
            $mainImage = Image::make($image)
                ->orientate() 
                ->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80);

            // Nombre único
            $fileName = $this->storage_path . '/' . uniqid() . '.jpg';

            // Subir imagen principal comprimida
            Storage::disk('s3')->put($fileName, (string) $mainImage, 'public');

            //  2. Crear thumb (300px de ancho)
            $thumbImage = Image::make($image)
                ->orientate() 
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75);

            $thumbFileName = $this->storage_path . '/thumbs/' . basename($fileName);

            // Subir thumb
            Storage::disk('s3')->put($thumbFileName, (string) $thumbImage, 'public');

            //  3. Eliminar `/` inicial si existe
            $fileName = ltrim($fileName, '/');
            $thumbFileName = ltrim($thumbFileName, '/');

            // 4. Guardar en modelo Foto
            $bucket = env('AWS_BUCKET_URL');
            $foto = new Foto([
                'model_id'    => $this->model->id,
                'model_type'  => get_class($this->model),
                'url'         => $bucket . $fileName,
                'url_thumb'   => $bucket . $thumbFileName,
            ]);

            $this->model->fotos()->save($foto);
            $this->model->load('fotos');
        }

        $this->images = [];
        $this->emit('ok', 'Se han subido fotos estilo WhatsApp 👍');
    }

    


    public function removePhoto($id)
    {
        $foto = Foto::findOrFail($id);
    
    
        $originalPath = str_replace(env('AWS_BUCKET_URL'), '', $foto->url);
        $thumbPath = str_replace(env('AWS_BUCKET_URL'), '', $foto->url_thumb);
    
    
        Storage::disk('s3')->delete([$originalPath, $thumbPath]);
    
    
        $foto->delete();
    
    
        $this->model->load('fotos');
    
    
        $this->emit('ok', 'Se han eliminado foto');
    }
    

    public function changeScope($id){
        $foto = Foto::findOrFail($id);
        $foto->update(['public' => !$foto->public]);
        $this->model->load('fotos');

        $state = $foto->public ? 'pública' : 'privada';
        $this->emit('ok', 'Se ha cambiado a foto ' . $state);
    }
}
