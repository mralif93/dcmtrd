<?php

namespace Database\Seeders;

use App\Models\Bond;
use App\Models\BondInfo;
use Illuminate\Database\Seeder;

class BondInfoSeeder extends Seeder
{
    public function run()
    {
        Bond::all()->each(function ($bond) {
            // Create or update to prevent duplicates
            BondInfo::updateOrCreate(
                ['bond_id' => $bond->id],
                BondInfo::factory()->make()->toArray()
            );
        });
    }
}