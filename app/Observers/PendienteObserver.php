<?php

namespace App\Observers;

use App\Models\Pendiente;
use Illuminate\Support\Facades\Cache;

class PendienteObserver
{
    public function created(Pendiente $pendiente)
    {
        if ($pendiente->user_id) {
            Cache::forget("pendientes_count_user_{$pendiente->user_id}");
        }
    }

    public function updated(Pendiente $pendiente)
    {
        if ($pendiente->isDirty('fecha_terminado') && $pendiente->user_id) {
            Cache::forget("pendientes_count_user_{$pendiente->user_id}");
        }
    }
}
