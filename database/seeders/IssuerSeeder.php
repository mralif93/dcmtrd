<?php

namespace Database\Seeders;

use App\Models\Issuer;
use Illuminate\Database\Seeder;

class IssuerSeeder extends Seeder
{
    public function run()
    {
        Issuer::factory()->count(5)->create();
    }
}