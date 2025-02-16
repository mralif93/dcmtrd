<?php

namespace Database\Factories;

use App\Models\RatingMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingMovementFactory extends Factory
{
    protected $model = RatingMovement::class;

    public function definition()
    {
        return [
            'rating_agency' => $this->faker->randomElement(['Moody\'s', 'S&P', 'Fitch']),
            'effective_date' => $this->faker->date(),
            'rating_tenure' => $this->faker->word,
            'rating' => $this->faker->randomElement(['AAA', 'AA+', 'AA', 'AA-']),
            'rating_action' => $this->faker->randomElement(['Upgrade', 'Downgrade', 'Affirmed']),
            'rating_outlook' => $this->faker->randomElement(['Stable', 'Positive', 'Negative']),
            'rating_watch' => $this->faker->randomElement(['Developing', 'Positive', 'Negative']),
            'bond_id' => \App\Models\Bond::factory(),
        ];
    }
}
