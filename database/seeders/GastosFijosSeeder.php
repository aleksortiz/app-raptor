<?php

namespace Database\Seeders;

use App\Models\Fabricante;
use App\Models\GastoFijo;
use Illuminate\Database\Seeder;

class GastosFijosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'RENTA',
            'LUZ',
            'TELEFONO',
            'SECRETARIA',
            'ALMACENISTA',
            'JEFE TALLER',
            'IMPUESTOS',
            'CONTADORA',
            'AGUA',
            'IMSS',
        ];

        foreach ($data as $item) {
            GastoFijo::create([
                'concepto' => $item,
            ]);
        }
    }
}
