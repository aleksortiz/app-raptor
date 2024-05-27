<?php

namespace Database\Seeders;

use App\Models\Personal;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Personal::factory(10)->create();
    }
}
