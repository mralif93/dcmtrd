<?php

namespace Database\Factories;

use App\Models\CallSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CallScheduleFactory extends Factory
{
    protected $model = CallSchedule::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d');
        
        return [
            'start_date' => $startDate,
            'end_date' => Carbon::parse($startDate)->addMonths(3)->format('Y-m-d'),
            'call_price' => $this->faker->randomFloat(2, 90, 110),
            'redemption_id' => \App\Models\Redemption::factory(),
        ];
    }
}
