<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Sucursal::create([
            'nombre' => 'LA CUESTA',
            'direccion' => '',
            'telefono' => '(123)456-78-90',
            'comentarios' => 'Sucursal prueba secundaria',
        ]);

        Sucursal::create([
            'nombre' => 'IGNACIO ALLENDE',
            'direccion' => '',
            'telefono' => '(123)456-78-90',
            'comentarios' => 'Sucursal prueba terciaria',
        ]);

        Sucursal::create([
            'nombre' => 'SUCURSAL CANCELADA',
            'direccion' => '',
            'telefono' => '(123)456-78-90',
            'comentarios' => 'Sucursal prueba terciaria',
            'canceled_at' => now(),
            'canceled_by' => 1,
        ]);
    }
}
