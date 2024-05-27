<?php

namespace App\Http\Livewire\Fotos;

use App\Http\Traits\PhotoTrait;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as InterventionImage;

class SubirFotos extends Component
{
    use WithFileUploads, PhotoTrait;

    public $model;
    public $storage_path;
    public $redirectMode;
    public $image;

    public $location_url = 'https://raptorv2.s3.amazonaws.com';

    protected $listeners = [
        'removePhoto'
    ];

    protected $queryString = ['redirectMode'];

    public function updatedImage(){
        $this->upload();
    }

    public function mount($model, $storage_path){
        $this->model = $model;
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

        // $img = InterventionImage::make("storage/{$name}");
        // $img->resize(1200, null, function($constraint){
        //     $constraint->aspectRatio();
        //     $constraint->upsize();
        // });
        // $img->save();

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
