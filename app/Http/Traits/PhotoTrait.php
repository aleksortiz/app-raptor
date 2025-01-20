<?php


namespace App\Http\Traits;

use App\Models\Foto;
use Illuminate\Support\Facades\Storage;

trait PhotoTrait {

    public function downloadPhoto($id){
        $foto = Foto::findOrFail($id);
        return Storage::disk('s3')->download($foto->location);
    }
}