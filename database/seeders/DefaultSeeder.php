<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\PresupuestoCategoria;
use App\Models\PresupuestoEspecialidad;
use App\Models\PresupuestoHeader;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        Sucursal::create([
            'nombre' => 'SAN LORENZO',
            'direccion' => '',
            'telefono' => '(123)456-78-90',
            'comentarios' => 'Sucursal principal',
        ]);

        $user = User::Create([
            'name' => 'Alejandro Ortiz',
            'email' => 'alejandro_ortiz426@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123'),
            'remember_token' => '',
            'sucursal_default' => 1,
        ]);

        $user2 = User::Create([
            'name' => 'Guillermo Villanueva',
            'email' => 'autoservicioraptor@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123'),
            'remember_token' => '',
            'sucursal_default' => 1,
        ]);

        $user->syncRoles('superuser');
        $user2->syncRoles('gerente');

        $this->call(AseguradoraSeeder::class);
        $this->call(FabricanteSeeder::class);
        $this->call(GastosFijosSeeder::class);

    }
}
