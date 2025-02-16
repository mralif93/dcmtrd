<?php

namespace Database\Factories;

use App\Models\TradingActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradingActivityFactory extends Factory
{
    protected $model = TradingActivity::class;

    public function definition()
    {
        return [
            'trade_date' => $this->faker->date(),
            'input_time' => $this->faker->time(),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'price' => $this->faker->randomFloat(2, 50, 200),
            'yield' => $this->faker->randomFloat(2, 1, 20),
            'value_date' => $this->faker->date(),
            'bond_id' => \App\Models\Bond::factory(),
        ];
    }
}
