<?php

namespace App\Console\Commands;

use App\Models\Entrada;
use App\Models\RegistroFactura;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncInvoicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $json = [
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "24-04-25",
                "numero_factura" => "A2507",
                "monto" => 7001.79,
                "fecha_pago" => null,
                "notas" => ""
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "26-10-25",
                "numero_factura" => "A2508",
                "monto" => 8764.00,
                "fecha_pago" => null,
                "notas" => ""
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "25-04-25",
                "numero_factura" => "A2509",
                "monto" => 20447.58,
                "fecha_pago" => null,
                "notas" => ""
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "25-12-25",
                "numero_factura" => "A2510",
                "monto" => 20709.29,
                "fecha_pago" => null,
                "notas" => ""
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "25-03-25",
                "numero_factura" => "A2511",
                "monto" => 4644.94,
                "fecha_pago" => null,
                "notas" => ""
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "24-08-25",
                "numero_factura" => "A2512",
                "monto" => 5486.22,
                "fecha_pago" => null,
                "notas" => ""
            ]
        ];
        
        
        $total = 0;
    
        foreach ($json as $item) {
            $folioConAnio = $item['model_folio'];
    
            $entrada = \App\Models\Entrada::where('folio', $folioConAnio)->first();
    
            if (!$entrada) {
                $this->warn("⚠️ Entrada no encontrada para folio: {$folioConAnio}");
                continue;
            }
    
            \App\Models\RegistroFactura::updateOrCreate(
                [
                    'model_type' => $item['model_type'],
                    'model_id' => $entrada->id,
                    'numero_factura' => strtoupper(trim($item['numero_factura'])),
                ],
                [
                    'monto' => $item['monto'],
                    'fecha_pago' => $item['fecha_pago'],
                    'notas' => $item['notas'],
                ]
            );
    
            $this->info("✅ Factura registrada para folio: {$folioConAnio}");
            $total++;
        }
        
        $this->info("🎉 Registro completo. Total insertados o actualizados: {$total}");
    }
        

}





