<?php

namespace Database\Factories;

use App\Models\Redemption;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedemptionFactory extends Factory
{
    protected $model = Redemption::class;

    public function definition()
    {
        return [
            'allow_partial_call' => $this->faker->boolean,
            'last_call_date' => $this->faker->date(),
            'redeem_nearest_denomination' => $this->faker->randomElement(['Yes', 'No']),
            'bond_id' => \App\Models\Bond::factory(),
        ];
    }
}
