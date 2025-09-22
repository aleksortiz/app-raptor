<?php

namespace App\Jobs;

use App\Mail\InventarioPdfMail;
use App\Models\EntradaInventario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInventarioPdfEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inventario;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EntradaInventario $inventario, string $email)
    {
        $this->inventario = $inventario;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new InventarioPdfMail($this->inventario));
    }
}
