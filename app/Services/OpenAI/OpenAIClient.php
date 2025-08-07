<?php

namespace App\Services\OpenAI;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OpenAIClient
{
    private string $apiKey;
    private string $baseUrl;
    private string $defaultModel;
    private int $timeoutSeconds;

    public function __construct(?string $apiKey = null, ?string $baseUrl = null, ?string $defaultModel = null, ?int $timeoutSeconds = null)
    {
        $this->apiKey = $apiKey ?? (string) config('openai.api_key');
        $this->baseUrl = rtrim($baseUrl ?? (string) config('openai.base_url'), '/');
        $this->defaultModel = $defaultModel ?? (string) config('openai.default_model');
        $this->timeoutSeconds = $timeoutSeconds ?? (int) config('openai.timeout', 60);

        if (empty($this->apiKey)) {
            throw new RuntimeException('OPENAI_API_KEY is not configured. Set it in your .env file.');
        }
    }

    public function getDefaultModel(): string
    {
        return $this->defaultModel;
    }

    public function uploadFile(UploadedFile|string $file, string $purpose = 'assistants'): array
    {
        $filePath = $file instanceof UploadedFile ? $file->getRealPath() : (string) $file;
        $fileName = $file instanceof UploadedFile ? $file->getClientOriginalName() : basename((string) $file);

        if (!is_readable($filePath)) {
            throw new RuntimeException("File not readable: {$filePath}");
        }

        $response = Http::withToken($this->apiKey)
            ->timeout($this->timeoutSeconds)
            ->attach('file', fopen($filePath, 'r'), $fileName)
            ->asMultipart()
            ->post($this->baseUrl . '/files', [
                ['name' => 'purpose', 'contents' => $purpose],
            ]);

        if (!$response->successful()) {
            Log::error('OpenAI file upload failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RuntimeException('OpenAI file upload failed: ' . $response->body());
        }

        return $response->json();
    }

    public function createResponseWithFile(string $fileId, string $systemPrompt, ?string $userPrompt = null, ?string $model = null): string
    {
        $payload = [
            'model' => $model ?: $this->defaultModel,
            'input' => [
                [
                    'role' => 'user',
                    'content' => array_values(array_filter([
                        ['type' => 'input_text', 'text' => $systemPrompt],
                        $userPrompt ? ['type' => 'input_text', 'text' => $userPrompt] : null,
                        ['type' => 'input_file', 'file_id' => $fileId],
                    ])),
                ],
            ],
        ];

        $response = Http::withToken($this->apiKey)
            ->timeout($this->timeoutSeconds)
            ->post($this->baseUrl . '/responses', $payload);

        if (!$response->successful()) {
            Log::error('OpenAI create response failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);
            throw new RuntimeException('OpenAI create response failed: ' . $response->body());
        }

        return $this->extractTextFromResponsesApi($response->json());
    }

    public function createResponseFromText(string $text, string $systemPrompt, ?string $userPrompt = null, ?string $model = null): string
    {
        $payload = [
            'model' => $model ?: $this->defaultModel,
            'input' => [
                [
                    'role' => 'user',
                    'content' => array_values(array_filter([
                        ['type' => 'input_text', 'text' => $systemPrompt],
                        $userPrompt ? ['type' => 'input_text', 'text' => $userPrompt] : null,
                        ['type' => 'input_text', 'text' => $text],
                    ])),
                ],
            ],
        ];

        $response = Http::withToken($this->apiKey)
            ->timeout($this->timeoutSeconds)
            ->post($this->baseUrl . '/responses', $payload);

        if (!$response->successful()) {
            Log::error('OpenAI create response (text) failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);
            throw new RuntimeException('OpenAI create response (text) failed: ' . $response->body());
        }

        return $this->extractTextFromResponsesApi($response->json());
    }

    private function extractTextFromResponsesApi(array $data): string
    {
        // Preferred: output[*].content[*].text
        if (isset($data['output']) && is_array($data['output'])) {
            $texts = [];
            foreach ($data['output'] as $block) {
                if (isset($block['content']) && is_array($block['content'])) {
                    foreach ($block['content'] as $contentItem) {
                        if (($contentItem['type'] ?? null) === 'output_text' && isset($contentItem['text'])) {
                            $texts[] = (string) $contentItem['text'];
                        } elseif (isset($contentItem['text'])) {
                            $texts[] = (string) $contentItem['text'];
                        }
                    }
                }
            }
            if (!empty($texts)) {
                return trim(implode("\n", $texts));
            }
        }

        // Fallback: top-level content
        if (isset($data['content']) && is_array($data['content'])) {
            $texts = [];
            foreach ($data['content'] as $contentItem) {
                if (isset($contentItem['text'])) {
                    $texts[] = (string) $contentItem['text'];
                }
            }
            if (!empty($texts)) {
                return trim(implode("\n", $texts));
            }
        }

        // Fallback: choices (Chat Completions style)
        if (isset($data['choices'][0]['message']['content'])) {
            return (string) $data['choices'][0]['message']['content'];
        }

        // Last resort: dump JSON
        return json_encode($data);
    }
} 