<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\PrecioMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material = new Material([
            'numero_parte' => 'EDX123',
            'categoria' => 'PLOMERIA',
            'descripcion' => 'Tubo de PVC',
            'unidad_medida' => 'PZ'
        ]);
        $material->save();
    }
}
