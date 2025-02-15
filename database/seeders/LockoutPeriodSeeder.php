<?php

namespace Database\Seeders;

use App\Models\Redemption;
use App\Models\LockoutPeriod;
use Illuminate\Database\Seeder;

class LockoutPeriodSeeder extends Seeder
{
    public function run()
    {
        // Create 1-3 lockout periods per bond
        Redemption::all()->each(function ($redemption) {
            LockoutPeriod::factory()
                ->count(rand(1, 3))
                ->create(['redemption_id' => $redemption->id]);
        });
    }
}