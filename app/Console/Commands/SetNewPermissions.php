<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class SetNewPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setpermissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set new permissions';

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
        Permission::where('name', 'administrar-contratistas')->delete();
        Permission::where('name', 'administrar-especialidades')->delete();
        Permission::where('name', 'administrar-preconceptos')->delete();
        Permission::where('name', 'administrar-presupuestos')->delete();
        Permission::where('name', 'administrar-proyectos')->delete();
        Permission::where('name', 'editar-factores')->delete();
        Permission::where('name', 'monitor-compras')->delete();
        Permission::where('name', 'ver-contratistas')->delete();
        Permission::where('name', 'ver-presupuestos')->delete();
        Permission::where('name', 'ver-proyectos')->delete();

        return 0;
    }
}
