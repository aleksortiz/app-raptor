<?php

namespace Database\Seeders;

use App\Models\Fabricante;
use Illuminate\Database\Seeder;

class FabricanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'ALFA ROMEO',
            'AUDI',
            'BMW',
            'CHEVROLET',
            'CHRYSLER',
            'DAEWOO',
            'DODGE',
            'FERRARI',
            'FIAT',
            'FORD',
            'HONDA',
            'HYUNDAI',
            'ISUZU',
            'JAGUAR',
            'JEEP',
            'KIA',
            'LAMBORGHINI',
            'LAND ROVER',
            'LEXUS',
            'MASERATI',
            'MAZDA',
            'MERCEDES',
            'MINI',
            'MITSUBISHI',
            'NISSAN',
            'PEUGEOT',
            'PORSCHE',
            'RENAULT',
            'ROVER',
            'SEAT',
            'SMART',
            'SUZUKI',
            'TOYOTA',
            'VOLKSWAGEN',
            'VOLVO',
        ];

        foreach ($data as $item) {
            Fabricante::create([
                'nombre' => $item,
            ]);
        }
    }
}
