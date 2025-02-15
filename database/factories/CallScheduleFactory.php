<?php

namespace Database\Factories;

use App\Models\Redemption;
use Illuminate\Database\Eloquent\Factories\Factory;

class CallScheduleFactory extends Factory
{
    public function definition()
    {
        $redemption = Redemption::inRandomOrder()->first() ?? Redemption::factory()->create();

        return [
            'redemption_id' => $redemption->id,
            'start_date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('+1 year', '+2 years')->format('Y-m-d'),
            'call_price' => $this->faker->randomFloat(2, 100, 110), // 100.00 to 110.00
        ];
    }
}