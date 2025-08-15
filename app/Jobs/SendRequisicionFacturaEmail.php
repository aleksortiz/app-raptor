<?php

namespace App\Jobs;

use App\Mail\RequisicionFacturaMail;
use App\Models\RequisicionFactura;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRequisicionFacturaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RequisicionFactura $requisicionFactura;
    protected string $toEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(RequisicionFactura $requisicionFactura, string $toEmail)
    {
        $this->requisicionFactura = $requisicionFactura;
        $this->toEmail = $toEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailable = new RequisicionFacturaMail($this->requisicionFactura);
        Mail::to($this->toEmail)->queue($mailable);
    }
} 