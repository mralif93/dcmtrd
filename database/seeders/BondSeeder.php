<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bond;

class BondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bond::factory()->count(10)->create();
    }
}