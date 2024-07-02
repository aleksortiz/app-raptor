<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SucursalSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(PersonalSeeder::class);
        $this->call(EntradasSeeder::class);

        Cliente::factory(80)->create();
    }
}
