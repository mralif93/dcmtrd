<?php

namespace Database\Factories;

use App\Models\LockoutPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LockoutPeriodFactory extends Factory
{
    protected $model = LockoutPeriod::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d');
        
        return [
            'start_date' => $startDate,
            'end_date' => Carbon::parse($startDate)->addMonths(2)->format('Y-m-d'),
            'redemption_id' => \App\Models\Redemption::factory(),
        ];
    }
}
