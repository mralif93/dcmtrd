<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issuer;

class IssuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Issuer::factory()->count(10)->create();
    }
}