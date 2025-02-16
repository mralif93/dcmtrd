<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Redemption;
use App\Models\Bond;

class RedemptionSeeder extends Seeder
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
            $redemption = Redemption::factory()->create([
                'bond_id' => $bond->id,
            ]);

            // Create Call Schedules for each Redemption
            \App\Models\CallSchedule::factory()->count(2)->create([
                'redemption_id' => $redemption->id,
            ]);

            // Create Lockout Periods for each Redemption
            \App\Models\LockoutPeriod::factory()->count(2)->create([
                'redemption_id' => $redemption->id,
            ]);
        }
    }
}