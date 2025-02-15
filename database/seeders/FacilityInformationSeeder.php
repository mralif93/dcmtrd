<?php

namespace Database\Seeders;

use App\Models\Issuer;
use App\Models\FacilityInformation;
use Illuminate\Database\Seeder;

class FacilityInformationSeeder extends Seeder
{
    public function run()
    {
        // Create 3-5 facilities per issuer
        foreach (Issuer::all() as $issuer) {
            FacilityInformation::factory()
                ->count(rand(3, 5))
                ->create(['issuer_id' => $issuer->id]);
        }
    }
}