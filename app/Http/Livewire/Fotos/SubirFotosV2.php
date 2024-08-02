<?php

namespace App\Http\Livewire\Fotos;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubirFotosV2 extends Component
{
    use WithFileUploads, PhotoTrait;

    public $model;
    public $storage_path;
    public $image;

    public $location_url = 'https://raptorv2.s3.amazonaws.com';

    protected $listeners = [
        'removePhoto',
        'loadFotos',
    ];

    public function loadFotos($model_id, $model_type){
        $this->model = app($model_type)::find($model_id);
    }

    public function updatedImage(){
        $this->upload();
    }

    public function mount($storage_path){
        $this->storage_path = $storage_path;
    }

    public function render()
    {
        return view('livewire.fotos.subir-fotos.view');
    }

    public function upload(){

        $this->validate([
            'image' => 'image|max:10000',
        ]);

        $name = $this->image->store($this->storage_path, 'public');

        $resizedImage = Storage::disk('public')->get($name);

        if(Storage::disk('s3')->put($name, $resizedImage)){
            Storage::disk('public')->delete($name);
            if($name){
                $foto = Foto::create([
                    'model_id' => $this->model->id,
                    'model_type' => get_class($this->model),
                    'url' => $name,
                ]);
                $this->emit('ok', 'Se ha subido foto');
                $this->model->fotos->push($foto);
            }
        }
    }

    public function removePhoto($id){

        $foto = Foto::findOrFail($id);
        if(Storage::disk('s3')->exists($foto->url))
        {
            Storage::disk('s3')->delete($foto->url);
            $this->emit('ok', 'Se ha eliminado foto', 'Foto eliminada');
        }

        $foto->delete();
        $this->model->load('fotos');
    }
}
