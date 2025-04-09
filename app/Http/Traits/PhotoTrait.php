<?php


namespace App\Http\Traits;

use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

trait PhotoTrait {

    public function downloadPhoto($id){
        $foto = Foto::findOrFail($id);
        return Storage::disk('s3')->download($foto->location);
    }

    public function downloadAllPhotos()
    {
        $model = $this->model;

        if ($model->fotos->isEmpty()) {
            abort(404, 'No hay fotos disponibles para este auto.');
        }

        $name = get_class($model) . '_' . $model->id;
        if($model->numero_reporte){
            $name = $model->numero_reporte;
        }


        $zipFileName = $name . '.zip';
        $tempZipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($model->fotos as $foto) {
                $fileContent = Storage::disk('s3')->get($foto->location); // Obtener contenido desde S3
                $fileName = basename($foto->location); // Nombre base del archivo
                $zip->addFromString($fileName, $fileContent); // Agregar al ZIP
            }
            $zip->close();
        } else {
            abort(500, 'No se pudo crear el archivo ZIP.');
        }

        return response()->download($tempZipPath)->deleteFileAfterSend(true);
    }
}