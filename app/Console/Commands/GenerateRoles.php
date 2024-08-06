<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Roles Generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Permission::create(['name' => 'administrar-entradas']);
        Permission::create(['name' => 'reporte-facturas']);
        Permission::create(['name' => 'reporte-depositos']);
        Permission::create(['name' => 'gastos-generales']);
        Permission::create(['name' => 'registrar-entrada']);
        Permission::create(['name' => 'vehiculos-entregados']);
        Permission::create(['name' => 'administrar-personal']);
        Permission::create(['name' => 'diagrama-nomina']);
        Permission::create(['name' => 'servicio-flotillas']);
        Permission::create(['name' => 'administrar-catalogos']);
        $this->info("Se han generado permisos");
    }
}
