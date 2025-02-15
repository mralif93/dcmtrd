<?php

namespace Database\Seeders;

use App\Models\BondInfo;
use App\Models\RatingMovement;
use Illuminate\Database\Seeder;

class RatingMovementSeeder extends Seeder
{
    public function run()
    {
        // Create 5-10 rating movements per bond_info
        foreach (BondInfo::all() as $bondInfo) {
            RatingMovement::factory()
                ->count(rand(5, 10)) // Random number of ratings per bond
                ->create([
                    'bond_info_id' => $bondInfo->id, // Link to the current bond_info
                ]);
        }
    }
}