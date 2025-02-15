<?php

namespace Database\Seeders;

use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Database\Seeder;

class BondSeeder extends Seeder
{
    public function run()
    {
        // Get existing issuers
        $issuers = Issuer::all();

        // Create 3 bonds per issuer
        $issuers->each(function ($issuer) {
            Bond::factory()
                ->count(3)
                ->create(['issuer_id' => $issuer->id]);
        });
    }
}