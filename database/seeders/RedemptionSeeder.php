<?php

namespace Database\Seeders;

use App\Models\BondInfo;
use App\Models\Redemption;
use Illuminate\Database\Seeder;

class RedemptionSeeder extends Seeder
{
    public function run()
    {
        foreach (BondInfo::all() as $bondInfo) {
            Redemption::factory()->create([
                'bond_info_id' => $bondInfo->id, // Link to existing bond_info
            ]);
        }

    }
}
