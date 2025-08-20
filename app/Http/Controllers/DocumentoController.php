<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class DocumentoController extends Controller
{
    /**
     * Obtener el tipo MIME basado en la extensión del archivo
     */
    private function getMimeType($extension)
    {
        $mimes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'txt' => 'text/plain',
        ];
        
        return $mimes[strtolower($extension)] ?? 'application/octet-stream';
    }
    
    /**
     * Descargar un documento desde S3
     */
    public function download(Request $request)
    {
        $url = $request->input('url');
        $filename = $request->input('filename', 'documento.pdf');
        
        if (empty($url)) {
            abort(404, 'URL no proporcionada');
        }
        
        // Si es una URL de S3 completa, extraer la ruta relativa
        $bucket = env('AWS_BUCKET_URL');
        if ($bucket && str_contains($url, $bucket)) {
            $path = str_replace($bucket, '', $url);
            $path = ltrim($path, '/');
            
            // Verificar si el archivo existe en S3
            if (Storage::disk('s3')->exists($path)) {
                // Obtener el contenido del archivo
                $contents = Storage::disk('s3')->get($path);
                
                // Determinar el tipo MIME basado en la extensión
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $mime = $this->getMimeType($extension);
                
                // Devolver una respuesta de descarga
                return response($contents)
                    ->header('Content-Type', $mime)
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            }
        }
        
        // Si no es una ruta de S3 o no se pudo encontrar, intentar descargar la URL directamente
        try {
            $client = new Client();
            $response = $client->get($url);
            
            return response($response->getBody(), 200)
                ->header('Content-Type', $response->getHeaderLine('Content-Type'))
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            abort(404, 'No se pudo descargar el archivo: ' . $e->getMessage());
        }
    }
}