<?php

namespace Database\Factories;

use App\Models\CallSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class CallScheduleFactory extends Factory
{
    protected $model = CallSchedule::class;

    public function definition()
    {
        return [
            'bond_id' => \App\Models\Bond::factory(),
            'call_date' => $this->faker->dateTimeBetween('now', '+5 years'),
            'call_price' => $this->faker->randomFloat(2, 95, 105),
            'call_conditions' => $this->faker->text(200),
        ];
    }
}