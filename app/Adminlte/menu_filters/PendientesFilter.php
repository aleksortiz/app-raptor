<?php

namespace App\Adminlte\menu_filters;

use App\Models\Pendiente;
use Illuminate\Support\Facades\Cache;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class PendientesFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['url']) && $item['url'] == '/taller/pendientes') {
            $user_id = auth()->id();

            $count = Cache::remember("pendientes_count_user_{$user_id}", now()->addDay(), function () use ($user_id) {
                return Pendiente::where('user_id', $user_id)
                    ->whereNull('fecha_terminado')
                    ->count();
            });

            if ($count <= 0) {
                return $item;
            }

            $item['label'] = $count;
            $item['label_color'] = 'danger';
        }

        return $item;
    }
}
