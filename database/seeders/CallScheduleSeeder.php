<?php

namespace Database\Seeders;

use App\Models\CallSchedule;
use App\Models\Redemption;
use Illuminate\Database\Seeder;

class CallScheduleSeeder extends Seeder
{
    public function run()
    {
        // Create 5-10 call schedules per redemption
        Redemption::all()->each(function ($redemption) {
            CallSchedule::factory()
                ->count(rand(5, 10))
                ->create(['redemption_id' => $redemption->id]);
        });
    }
}