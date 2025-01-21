<?php

namespace App\Http\Livewire\Foto;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

    public function upload(){

        $this->validate();

        foreach ($this->images as $image) {
            $fileName = $image->store($this->storage_path, 's3');

            if ($fileName) {
                $location = env('AWS_BUCKET_URL') . $fileName;
                $foto = new Foto([
                    'model_id' => $this->model->id,
                    'model_type' => get_class($this->model),
                    'url' => $location,
                ]);
                $this->model->fotos()->save($foto);
                $this->model->load('fotos');
            }
        }

        

        $this->images = [];
        // $this->emit('ok', 'Se han subido fotos');

    }

    public function removePhoto($id){

        $foto = Foto::findOrFail($id);
        if(Storage::disk('s3')->exists($foto->location))
        {
            Storage::disk('s3')->delete($foto->location);
            // $this->emit('ok', 'Se ha eliminado foto');
        }

        $foto->delete();
        $this->model->load('fotos');
    }
}
