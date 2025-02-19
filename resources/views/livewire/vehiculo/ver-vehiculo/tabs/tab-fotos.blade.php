<div class="card m-0" style="min-height: 65vh;">
    <div class="card-body">

        @livewire('fotos.subir-fotos-v3', [
            'model_id' => $this->vehiculo->id,
            'model_type' => 'App\\Models\\Vehiculo',
            'storage_path' => "/vehiculos/{$this->vehiculo->id}",
        ])

    </div>
</div>
