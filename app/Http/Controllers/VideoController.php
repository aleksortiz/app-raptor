<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Entrada;
use App\Models\Valuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Subir un video
     */
    public function store(Request $request)
    {
        try {
            // Log de entrada
            \Log::info('Video upload request received', [
                'has_file' => $request->hasFile('video'),
                'model_type' => $request->input('model_type'),
                'model_id' => $request->input('model_id'),
            ]);

            $request->validate([
                'video' => 'required|file|mimes:mp4,mov,avi,wmv,flv,webm|max:102400', // Max 100MB
                'model_type' => 'required|string',
                'model_id' => 'required|integer',
                'description' => 'nullable|string|max:500',
                'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // Max 5MB
            ]);

            $file = $request->file('video');
            $modelType = $request->input('model_type');
            
            // Normalizar el model_type para asegurar que tenga backslashes
            // Puede venir como "AppModelsEntrada" o "App\Models\Entrada" o "App\\Models\\Entrada"
            $modelType = str_replace(['/', '\\\\'], '\\', $modelType);
            if (!str_contains($modelType, '\\') && str_starts_with($modelType, 'App')) {
                // Si viene sin backslashes, agregarlos: AppModelsEntrada -> App\Models\Entrada
                $modelType = preg_replace('/^(App)(Models)(.+)$/', '$1\\\\$2\\\\$3', $modelType);
            }
            
            $modelId = $request->input('model_id');
            
            // Generar nombre único para el video
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Guardar en storage/app/public/videos por defecto (preparado para S3)
            $path = $file->storeAs('videos', $filename, 'public');
            
            // Procesar thumbnail si existe
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailFilename = Str::uuid() . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnailPath = $thumbnail->storeAs('videos/thumbnails', $thumbnailFilename, 'public');
            }
            
            // Crear registro en BD
            $video = Video::create([
                'model_type' => $modelType,
                'model_id' => $modelId,
                'url' => $path,
                'thumbnail' => $thumbnailPath,
                'filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'duration' => $request->input('duration'), // Se enviará desde el frontend
                'description' => $request->input('description'),
                'public' => $request->input('public', false),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video subido exitosamente',
                'video' => $video,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Video validation failed', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . json_encode($e->errors()),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Video upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el video: ' . $e->getMessage(),
                'error_type' => get_class($e),
            ], 500);
        }
    }

    /**
     * Listar videos de un modelo
     */
    public function index(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $modelType = $request->input('model_type');
        
        // Normalizar el model_type para asegurar que tenga backslashes
        $modelType = str_replace(['/', '\\\\'], '\\', $modelType);
        if (!str_contains($modelType, '\\') && str_starts_with($modelType, 'App')) {
            $modelType = preg_replace('/^(App)(Models)(.+)$/', '$1\\\\$2\\\\$3', $modelType);
        }

        $videos = Video::where('model_type', $modelType)
            ->where('model_id', $request->input('model_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'videos' => $videos,
        ]);
    }

    /**
     * Eliminar un video
     */
    public function destroy($id)
    {
        try {
            $video = Video::findOrFail($id);
            
            // Eliminar archivos físicos
            if (Storage::disk('public')->exists($video->url)) {
                Storage::disk('public')->delete($video->url);
            }
            
            if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            
            // Eliminar registro
            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video eliminado exitosamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el video: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener un video específico
     */
    public function show($id)
    {
        try {
            $video = Video::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'video' => $video,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Video no encontrado',
            ], 404);
        }
    }

    /**
     * Actualizar descripción del video
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $video = Video::findOrFail($id);
            $video->update([
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video actualizado exitosamente',
                'video' => $video,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el video: ' . $e->getMessage(),
            ], 500);
        }
    }
}
