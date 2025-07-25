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
                "model_folio" => "18-07-25",
                "numero_factura" => "A2539",
                "monto" => 18290.10,
                "fecha_pago" => "2025-07-11",
                "notas" => "Pago conjunto con A2540"
            ],
            [
                "model_type" => "App\\Models\\Entrada",
                "model_folio" => "28-11-25",
                    "numero_factura" => "A2541",
                    "monto" => 3362.84,
                    "fecha_pago" => "2025-07-11",
                    "notas" => ""
                ],
                [
                    "model_type" => "App\\Models\\Entrada",
                    "model_folio" => "25-02-25",
                    "numero_factura" => "A2546",
                    "monto" => 13940.68,
                    "fecha_pago" => null,
                    "notas" => ""
                ],
                [
                    "model_type" => "App\\Models\\Entrada",
                    "model_folio" => "25-06-25",
                    "numero_factura" => "A2545",
                    "monto" => 6190.24,
                    "fecha_pago" => null,
                    "notas" => ""
                ],
                [
                    "model_type" => "App\\Models\\Entrada",
                    "model_folio" => "26-01-25",
                    "numero_factura" => "A2543",
                    "monto" => 16820.00,
                    "fecha_pago" => null,
                    "notas" => ""
                ],
                [
                    "model_type" => "App\\Models\\Entrada",
                    "model_folio" => "26-07-25",
                    "numero_factura" => "A2547",
                    "monto" => 7932.28,
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





