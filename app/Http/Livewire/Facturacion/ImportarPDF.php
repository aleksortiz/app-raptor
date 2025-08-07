<?php

namespace App\Http\Livewire\Facturacion;

use App\Services\OpenAI\OpenAIClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportarPDF extends Component
{
    use WithFileUploads;

    public $pdf; // UploadedFile
    public string $prompt = '';
    public ?string $responseText = null;
    public bool $isLoading = false;

    protected function rules(): array
    {
        return [
            'pdf' => 'required|file|mimes:pdf|max:20480', // 20MB
            'prompt' => 'nullable|string',
        ];
    }

    public function render()
    {
        return view('livewire.facturacion.importar-pdf.view');
    }

    public function procesar(): void
    {
        $this->validate();

        $this->isLoading = true;
        $this->responseText = null;

        try {
            $client = new OpenAIClient();

            // 1) Subir el archivo PDF a OpenAI
            $upload = $client->uploadFile($this->pdf, 'assistants');
            $fileId = (string) ($upload['id'] ?? '');
            if ($fileId === '') {
                throw new \RuntimeException('No se obtuvo file_id al subir el PDF a OpenAI.');
            }

            // 2) Crear la respuesta usando el archivo y el prompt del usuario
            $systemPrompt = 'Eres un asistente que lee un archivo PDF y devuelve EXCLUSIVAMENTE un JSON válido siguiendo estrictamente el esquema indicado en el prompt del usuario. Si hay valores faltantes, usa null. No agregues comentarios ni explicaciones.';

            $resultText = $client->createResponseWithFile(
                $fileId,
                $systemPrompt,
                $this->prompt
            );

            $this->responseText = $resultText;
        } catch (\Throwable $e) {
            Log::error('Error al procesar ImportarPDF', [
                'message' => $e->getMessage(),
            ]);
            throw ValidationException::withMessages([
                'pdf' => 'Error al procesar el PDF: ' . $e->getMessage(),
            ]);
        } finally {
            $this->isLoading = false;
        }
    }

    public function resetForm(): void
    {
        $this->reset(['pdf', 'prompt', 'responseText', 'isLoading']);
    }
} 