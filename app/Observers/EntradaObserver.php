<?php

namespace App\Observers;

use App\Models\Entrada;
use Illuminate\Support\Facades\Cache;

class EntradaObserver
{
    public function updated(Entrada $entrada)
    {
        if ($entrada->isDirty('fecha_entrega')) {
            Cache::forget("vehiculos_en_piso");
        }
    }
}
