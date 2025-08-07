<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title mb-0">Importar PDF para Facturación</h3>
            <div>
                <button class="btn btn-sm btn-secondary" wire:click="resetForm" type="button">
                    Limpiar
                </button>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="procesar">
                <div class="form-group">
                    <label for="pdf">Archivo PDF</label>
                    <input type="file" id="pdf" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf" accept="application/pdf">
                    @error('pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="prompt">Prompt/Esquema JSON</label>
                    <textarea id="prompt" rows="6" class="form-control @error('prompt') is-invalid @enderror" wire:model.defer="prompt" placeholder="Especifica aquí el esquema JSON esperado y reglas de parseo."></textarea>
                    @error('prompt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 d-flex align-items-center">
                    <button class="btn btn-primary" type="submit" @if($isLoading) disabled @endif>
                        @if($isLoading)
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Procesando...
                        @else
                            Enviar a OpenAI
                        @endif
                    </button>

                    <div class="ml-3 text-muted small">
                        Modelo: {{ config('openai.default_model') }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($responseText)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title mb-0">Resultado (JSON)</h3>
            </div>
            <div class="card-body">
                <pre class="mb-0" style="white-space: pre-wrap; word-break: break-word;">{{ $responseText }}</pre>
            </div>
        </div>
    @endif
</div> 