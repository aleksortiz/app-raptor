<?php

namespace App\Adminlte\menu_filters;

use App\Models\Entrada;
use Illuminate\Support\Facades\Cache;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class PisoFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['text']) && $item['text'] == 'Piso') {

            $count = Cache::remember("vehiculos_en_piso", now()->addDay(), function () {
                return Entrada::where('fecha_entrega', null)->count();
            });

            if ($count <= 0) {
                return $item;
            }

            $item['label'] = $count;
            $item['label_color'] = 'success';
        }

        return $item;
    }
}
