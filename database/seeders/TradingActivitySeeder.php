<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TradingActivity;
use App\Models\Bond;

class TradingActivitySeeder extends Seeder
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
            TradingActivity::factory()->count(5)->create([
                'bond_id' => $bond->id,
            ]);
        }
    }
}