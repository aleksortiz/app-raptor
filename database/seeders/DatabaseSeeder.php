<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultSeeder::class);
        if(env('APP_ENV') == 'local')
        {
            $this->call(TestSeeder::class);
        }

    }
}
