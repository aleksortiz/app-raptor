<?php

namespace App\Http\Livewire\Fotos;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

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

    // public function updatedImages(){
    //     $this->upload();
    // }

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
        $this->emit('ok', 'Se han subido fotos');

    }

    public function removePhoto($id){

        $foto = Foto::findOrFail($id);
        if(Storage::disk('s3')->exists($foto->location))
        {
            Storage::disk('s3')->delete($foto->location);
            $this->emit('ok', 'Se ha eliminado foto');
        }

        $foto->delete();
        $this->model->load('fotos');
    }
}
