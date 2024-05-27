<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::factory(200)->create();
        Contacto::factory(500)->create();
    }
}
