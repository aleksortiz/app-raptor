<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Entrada;
use Illuminate\Database\Seeder;

class EntradasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombre' => 'Cliente 1',
            'rfc' => 'RFC1',
        ]);
        Entrada::factory(10)->create();
    }
}
