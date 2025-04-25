<?php

namespace App\Http\Livewire\Foto;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Intervention\Image\Facades\Image;


class UploadMobilePhotos extends Component
{
    use WithFileUploads, PhotoTrait;

    public $model;
    public $storage_path;
    public $redirectMode;
    public $images = [];

    public $token;

    protected $listeners = [
        'removePhoto'
    ];

    protected $rules = [
        'images.*' => 'image|max:10240',
    ];

    protected $queryString = ['token'];

    public function mount(){
        $this->getDataFromToken($this->token);
    }

    public function getDataFromToken($token){
        $key = env('JWT_SECRET');
        try {
            $jwt = JWT::decode($token, new Key($key, 'HS256'));
            $this->model = app($jwt->model_type)->find($jwt->model_id);
        } catch (\Exception $e) {
            abort(403, 'Token inválido');
        }
    }

    public function render()
    {
        return view('livewire.foto.upload-mobile-photos.view');
    }


    public function cancelar(){
        $this->images = [];
    }

    // public function upload()
    // {
    //     $this->validate();
    
    //     foreach ($this->images as $image) {
        
    //         $fileName = $image->store($this->storage_path, 's3');
    
    //         if ($fileName) {
    //             $bucket = env('AWS_BUCKET_URL');
    
    //             $thumbImage = Image::make($image)
    //             ->resize(600, null, function ($constraint) {
    //                 $constraint->aspectRatio(); // Mantiene la proporción
    //                 $constraint->upsize(); // No aumenta el tamaño si es menor a 1200px
    //             })
    //             ->encode('jpg', 80); 


    //             $thumbFileName = $this->storage_path . '/thumbs/' . basename($fileName);
    //             Storage::disk('s3')->put($thumbFileName, (string) $thumbImage->encode('jpg', 90), 'public');

    //             if(str_starts_with($thumbFileName, '/')){
    //                 $thumbFileName = substr($thumbFileName, 1);
    //             }
    //             if(str_starts_with($fileName, '/')){
    //                 $fileName = substr($fileName, 1);
    //             }
    
    //             $foto = new Foto([
    //                 'model_id' => $this->model->id,
    //                 'model_type' => get_class($this->model),
    //                 'url' => $bucket . $fileName,
    //                 'url_thumb' => $bucket . $thumbFileName,
    //             ]);
    
    //             $this->model->fotos()->save($foto);
    //             $this->model->load('fotos');
    //         }
    //     }
    
    //     $this->images = [];
    //     $this->emit('ok', 'Se han subido fotos');
    // }

    public function upload()
    {
        $this->validate();

        foreach ($this->images as $image) {
            $mainImage = Image::make($image)
                ->orientate() 
                ->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80);

            $fileName = $this->storage_path . '/' . uniqid() . '.jpg';

            Storage::disk('s3')->put($fileName, (string) $mainImage, 'public');

            $thumbImage = Image::make($image)
                ->orientate() 
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75);

            $thumbFileName = $this->storage_path . '/thumbs/' . basename($fileName);

            Storage::disk('s3')->put($thumbFileName, (string) $thumbImage, 'public');

            $fileName = ltrim($fileName, '/');
            $thumbFileName = ltrim($thumbFileName, '/');

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
}
