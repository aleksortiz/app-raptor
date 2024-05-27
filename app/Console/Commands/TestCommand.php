<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use App\Models\ContactoPresupuesto;
use App\Models\Presupuesto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

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
        // $mail = new TestMail();
        // Mail::to('alejandro_ortiz426@hotmail.com')->queue($mail);
        // $ppto->save();
        $this->info("Realizado");
    }
}
