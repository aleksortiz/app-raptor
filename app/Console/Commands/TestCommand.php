<?php

namespace App\Console\Commands;

use App\Mail\RegistroCitaMailable;
use App\Mail\TestMail;
use App\Models\ContactoPresupuesto;
use App\Models\Presupuesto;
use App\Models\RegistroQr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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
        $registro = RegistroQr::find(1);
        $mailable = new RegistroCitaMailable($registro);
        Mail::to('alejandro_ortiz426@hotmail.com')->queue($mailable);
        $this->info("Realizado");
    }
}
