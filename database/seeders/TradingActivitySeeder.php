<?php

namespace Database\Seeders;

use App\Models\BondInfo;
use App\Models\TradingActivity;
use Illuminate\Database\Seeder;

class TradingActivitySeeder extends Seeder
{
    public function run()
    {
        // Create 50-100 trading activities per bond
        foreach (BondInfo::all() as $bondInfo) {
            TradingActivity::factory()
                ->count(rand(50, 100))
                ->create(['bond_info_id' => $bondInfo->id]);
        }
    }
}