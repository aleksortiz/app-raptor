<?php

namespace App\Http\Livewire\Facturacion;

use App\Services\OpenAI\OpenAIClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Entrada;

class ImportarPDF extends Component
{
    use WithFileUploads;

    public $pdf; // UploadedFile
    public ?string $responseText = null;
    public bool $isLoading = false;
    public array $rows = [];

    protected function rules(): array
    {
        return [
            'pdf' => 'required|file|mimes:pdf|max:20480', // 20MB
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
        $this->rows = [];

        try {
            $client = new OpenAIClient();

            // 1) Subir el archivo PDF a OpenAI
            $upload = $client->uploadFile($this->pdf, 'assistants');
            $fileId = (string) ($upload['id'] ?? '');
            if ($fileId === '') {
                throw new \RuntimeException('No se obtuvo file_id al subir el PDF a OpenAI.');
            }

            // 2) Prompts del sistema y del usuario (hardcodeado)
            $systemPrompt = 'Eres un asistente que lee un archivo PDF y devuelve EXCLUSIVAMENTE un JSON válido siguiendo estrictamente el esquema indicado en el prompt del usuario. Si hay valores faltantes, usa null. No agregues comentarios ni explicaciones.';

            $userPrompt = <<<'PROMPT'
You are given a PDF in Spanish containing weekly billing data (e.g., “SEM 28”) with rows that include “FOLIO INTERNO”, client, invoice number (e.g., “A2541”), and monetary columns (labor, parts, VAT, TOTAL, etc.), plus a separate section listing payments with dates and invoice references.

Goal: Extract only the invoice rows and produce a JSON array of objects with this exact schema (and nothing else in the output):

\[
{
"model_type": "App\\Models\\Entrada",
"model_folio": "NN-NN-25",
"numero_factura": "AXXXX",
"monto": 0.00,
"fecha_pago": null,
"notas": ""
}
]

Mapping rules:

1. model_type

   * Always the literal string: App\Models\Entrada

2. model_folio (comes from “FOLIO INTERNO”)

   * Extract the folio like 18-07, 28-11, etc.
   * If the folio does not include the year, append -25 (e.g., 18-07 → 18-07-25).
   * If it already includes -25, keep as is.
   * If the row has no folio interno, skip that row.

3. numero_factura

   * Extract the invoice number that starts with “A” followed by digits (e.g., A2539, A2541).
   * Uppercase and trim.
   * If missing or malformed, skip the row.

4. monto

   * Use the TOTAL column for that row (not ABONO nor SALDO).
   * Convert to a number (float). Remove thousands separators and use . as the decimal separator.
   * Example: $ 13,940.68 → 13940.68
   * If TOTAL is missing, try to compute labor + parts + VAT, otherwise skip the row.

5. fecha_pago

   * Look up the payments section (e.g., lines like: QUALITAS 11/07/2025 ... SEM 28 A2539-A2540 24492332).
   * If a payment line mentions the exact invoice number for this row, set fecha_pago to that payment’s date in YYYY-MM-DD format (e.g., 2025-07-11).
   * If multiple payments reference the same invoice, pick the earliest date.
   * If no payment found for that invoice, set fecha_pago to null.

6. notas

   * Default to an empty string "" unless there is a clear, short note on the same invoice row specifically tied to that entry. If unsure, leave "".

Parsing guidance & constraints:

* The PDF is in Spanish; numbers use $, thousands separators , and decimal separator .
* Ignore summary totals, ABONO, SALDO, subtotals, and any aggregate rows not tied to a specific invoice.
* Ignore other sheets/blocks like historical tables or unrelated “FACTURAS DE CLIENTES” unless they match the same week’s invoice rows and include a valid FOLIO INTERNO + Axxxx.
* Some invoice rows may not visually align; rely on patterns:

  * FOLIO INTERNO: patterns like NN-NN or NN-NN-25
  * numero_factura: A followed by digits
  * TOTAL: rightmost monetary figure on the invoice’s main row
* De-duplicate by (model_folio, numero_factura). Keep the latest parsed occurrence if duplicates conflict.
* Dates in the PDF are DD/MM/YYYY. Convert to YYYY-MM-DD.
* Output only the JSON array with the extracted objects. No Markdown, no comments, no code fences.

Validation:

* Ensure every object contains all required keys with correct types:

  * model_type: string
  * model_folio: string
  * numero_factura: string
  * monto: number
  * fecha_pago: string in YYYY-MM-DD or null
  * notas: string
* If no valid rows are found, output [].

Return only the JSON array as the final answer.
PROMPT;

            $resultText = $client->createResponseWithFile(
                $fileId,
                $systemPrompt,
                $userPrompt
            );

            $this->responseText = $resultText;

            // 3) Intentar decodificar el JSON para mostrarlo en tabla
            $decoded = json_decode($resultText, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Enriquecer filas con referencia a Entrada existente
                $folios = [];
                foreach ($decoded as $item) {
                    if (isset($item['model_folio']) && is_string($item['model_folio']) && $item['model_folio'] !== '') {
                        $folios[] = $item['model_folio'];
                    }
                }
                $folios = array_values(array_unique($folios));

                $folioToId = [];
                if (!empty($folios)) {
                    $folioToId = Entrada::whereIn('folio', $folios)->pluck('id', 'folio')->toArray();
                }

                $prepared = [];
                foreach ($decoded as $item) {
                    $folio = (string) ($item['model_folio'] ?? '');
                    $entradaId = $folio !== '' && isset($folioToId[$folio]) ? (int) $folioToId[$folio] : null;

                    $prepared[] = [
                        'model_folio' => $folio,
                        'numero_factura' => $item['numero_factura'] ?? '',
                        'monto' => $item['monto'] ?? null,
                        'fecha_pago' => $item['fecha_pago'] ?? null,
                        'notas' => $item['notas'] ?? '',
                        '_entrada_exists' => $entradaId !== null,
                        '_entrada_url' => $entradaId
                            ? url('/servicios/' . $entradaId)
                            : url('/servicios/busqueda?folio=' . urlencode($folio)),
                    ];
                }

                $this->rows = $prepared;
            } else {
                // Si la respuesta no es JSON válido, lanzamos error para informar al usuario
                throw new \RuntimeException('La respuesta de OpenAI no es un JSON válido.');
            }
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
        $this->reset(['pdf', 'responseText', 'isLoading', 'rows']);
    }
} 