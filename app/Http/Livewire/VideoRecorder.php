<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoRecorder extends Component
{
    use WithFileUploads;

    public $modelType;
    public $modelId;
    public $videos = [];
    public $showModal = false;
    public $description = '';
    
    protected $listeners = ['refreshVideos' => '$refresh'];

    public function mount($modelType, $modelId)
    {
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->loadVideos();
    }

    public function loadVideos()
    {
        // Normalizar el model_type para búsqueda
        $normalizedModelType = str_replace(['/', '\\\\'], '\\', $this->modelType);
        if (!str_contains($normalizedModelType, '\\') && str_starts_with($normalizedModelType, 'App')) {
            $normalizedModelType = preg_replace('/^(App)(Models)(.+)$/', '$1\\\\$2\\\\$3', $normalizedModelType);
        }
        
        // Buscar con el model_type normalizado O con el formato sin backslashes
        // para compatibilidad con registros antiguos
        $modelTypeWithoutSlashes = str_replace('\\', '', $normalizedModelType);
        
        $this->videos = Video::where(function($query) use ($normalizedModelType, $modelTypeWithoutSlashes) {
                $query->where('model_type', $normalizedModelType)
                      ->orWhere('model_type', $modelTypeWithoutSlashes);
            })
            ->where('model_id', $this->modelId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->description = '';
        $this->emit('openVideoModal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->description = '';
        $this->emit('closeVideoModal');
    }

    public function deleteVideo($videoId)
    {
        try {
            $video = Video::findOrFail($videoId);
            
            // Verificar que el video pertenece al modelo correcto
            if ($video->model_type !== $this->modelType || $video->model_id != $this->modelId) {
                $this->emit('error', 'No tienes permiso para eliminar este video');
                return;
            }
            
            // Eliminar archivos físicos
            if (Storage::disk('public')->exists($video->url)) {
                Storage::disk('public')->delete($video->url);
            }
            
            if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            
            // Eliminar registro
            $video->delete();

            $this->loadVideos();
            $this->emit('ok', 'Video eliminado exitosamente');

        } catch (\Exception $e) {
            $this->emit('error', 'Error al eliminar el video: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.video-recorder', [
            'videos' => $this->videos
        ]);
    }
}
