<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RatingMovement;
use App\Models\Bond;

class RatingMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonds = Bond::all();

        foreach ($bonds as $bond) {
            RatingMovement::factory()->count(3)->create([
                'bond_id' => $bond->id,
            ]);
        }
    }
}