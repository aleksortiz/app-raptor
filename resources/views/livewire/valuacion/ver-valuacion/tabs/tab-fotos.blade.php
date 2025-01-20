<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">

        @livewire('fotos.subir-fotos-v3', [
            'model_id' => $this->valuacion?->id,
            'model_type' => 'App\\Models\\Valuacion',
            'storage_path' => "/valuaciones/{$this->valuacion?->id}",
        ])

    </div>
</div>
