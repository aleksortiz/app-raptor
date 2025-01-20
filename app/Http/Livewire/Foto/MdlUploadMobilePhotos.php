<?php

namespace App\Http\Livewire\Foto;

use App\Models\Valuacion;
use Livewire\Component;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MdlUploadMobilePhotos extends Component
{

    public $mdlName = 'mdlUploadMobilePhotos';
    public $token;

    public $model_id;
    public $model_type;
    public $storage_path;

    public $qrString;

    public function mount($model_id, $model_type, $storage_path){
        $this->model_id = $model_id;
        $this->model_type = $model_type;
        $this->storage_path = $storage_path;


        $this->createToken();
    }

    public function render()
    {
        return view('livewire.foto.mdl-upload-mobile-photos');
    }

    public function show()
    {
        $this->emit('showModal', $this->mdlName);
    }

    public function createToken(){
        $key = env('JWT_SECRET');
        $payload = [
            'model_id' => $this->model_id,
            'model_type' => $this->model_type,
            'storage_path' => $this->storage_path,
            'exp' => time() + 60 * 60 // 1 hour
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        $this->token = $jwt;
        $this->qrString = url("/upload-mobile-photos?token=$jwt");

    }

    public function validateToken(){
        $key = env('JWT_SECRET');
        try {
            JWT::decode($this->token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }
    }
    

    
}
