<?php

namespace Database\Seeders;

use App\Models\Aseguradora;
use Illuminate\Database\Seeder;

class AseguradoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'N/A',
            'AFIRME',
            'ATLAS',
            'AXXA',
            'GNP',
            'QUALITAS',
        ];

        foreach ($data as $item) {
            Aseguradora::create([
                'nombre' => $item,
            ]);
        }

    }
}
