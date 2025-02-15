<?php

namespace Database\Factories;

use App\Models\Issuer;
use App\Models\Bond;
use Illuminate\Database\Eloquent\Factories\Factory;

class BondFactory extends Factory
{
    protected $model = Bond::class;

    public function definition()
    {
        return [
            'bond_sukuk_name' => 'BND-' . $this->faker->unique()->randomNumber(4),
            'sub_name' => $this->faker->word,
            'rating' => $this->faker->randomElement(['AAA', 'AA+', 'A', 'BBB']),
            'category' => $this->faker->randomElement(['Government', 'Corporate']),
            'last_traded_date' => $this->faker->dateTimeBetween('-1 year'),
            'last_traded_yield' => $this->faker->randomFloat(2, 1, 10),
            'last_traded_price' => $this->faker->randomFloat(4, 50, 200),
            'last_traded_amount' => $this->faker->randomFloat(2, 1000, 100000),
            'o_s_amount' => $this->faker->randomFloat(2, 1000000, 10000000),
            'residual_tenure' => $this->faker->numberBetween(1, 10),
            'facility_code' => 'FAC-' . $this->faker->unique()->randomNumber(4),
            'status' => $this->faker->randomElement(['Active', 'Matured']),
            'approval_date_time' => $this->faker->dateTimeBetween('-2 years'),
            'issuer_id' => Issuer::factory(),
        ];
    }
}