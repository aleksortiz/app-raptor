<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = Role::create(['name' => 'superuser']);
        $gerente = Role::create(['name' => 'gerente']);
        $administrador = Role::create(['name' => 'administrador']);
        $presupuestador = Role::create(['name' => 'presupuestador']);
        $comprador = Role::create(['name' => 'comprador']);
        $auxiliar_administrativo = Role::create(['name' => 'auxiliar-administrativo']);

        Permission::create(['name' => 'administrar-clientes'])->syncRoles([$superuser, $gerente, $administrador, $comprador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'administrar-contratistas'])->syncRoles([$superuser, $gerente, $administrador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'administrar-especialidades'])->syncRoles([$superuser, $gerente, $administrador]);
        Permission::create(['name' => 'administrar-materiales'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador]);
        // Permission::create(['name' => 'administrar-preconceptos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador]);
        // Permission::create(['name' => 'administrar-presupuestos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador]);
        Permission::create(['name' => 'administrar-permisos'])->syncRoles([$superuser, $gerente, $administrador]);
        Permission::create(['name' => 'administrar-proveedores'])->syncRoles([$superuser, $gerente, $administrador, $comprador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'administrar-proyectos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $auxiliar_administrativo]);
        Permission::create(['name' => 'administrar-usuarios'])->syncRoles([$superuser, $gerente, $administrador ]);
        Permission::create(['name' => 'autorizar-orden-compra'])->syncRoles([$superuser, $gerente, $administrador]);
        Permission::create(['name' => 'autorizar-solicitud-compra'])->syncRoles([$superuser, $gerente, $administrador]);
        Permission::create(['name' => 'crear-orden-compra'])->syncRoles([$superuser, $gerente, $administrador,$comprador]);
        Permission::create(['name' => 'crear-solicitud-compra'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador]);
        // Permission::create(['name' => 'editar-factores'])->syncRoles([$superuser, $gerente, $administrador]);
        // Permission::create(['name' => 'monitor-compras'])->syncRoles([$superuser, $gerente, $administrador, $comprador]);
        Permission::create(['name' => 'tickets-soporte'])->syncRoles([$superuser, $gerente, $administrador]);
        Permission::create(['name' => 'ver-clientes'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'ver-contratistas'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        Permission::create(['name' => 'ver-materiales'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'ver-presupuestos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        Permission::create(['name' => 'ver-proveedores'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        // Permission::create(['name' => 'ver-proyectos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        Permission::create(['name' => 'enviar-pedidos'])->syncRoles([$superuser, $gerente, $administrador, $presupuestador, $comprador, $auxiliar_administrativo]);
        Permission::create(['name' => 'reporte-finanzas'])->syncRoles([$superuser, $gerente]);
        Permission::create(['name' => 'admin-personal-administrativo'])->syncRoles([$superuser, $gerente]);
    }
}
