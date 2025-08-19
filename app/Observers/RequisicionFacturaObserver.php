<?php

namespace App\Observers;

use App\Jobs\SendRequisicionFacturaEmail;
use App\Models\RequisicionFactura;

class RequisicionFacturaObserver
{
    public function created(RequisicionFactura $requisicionFactura): void
    {
        $to = env('REQUISICION_FACTURA_TO', 'alejandro_ortiz426@hotmail.com');
        if ($to) {
            // SendRequisicionFacturaEmail::dispatch($requisicionFactura->fresh(), $to);
        }
    }
} 