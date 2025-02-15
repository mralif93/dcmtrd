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
            // Link to bond_infos table
            'bond_info_id' => \App\Models\BondInfo::factory(), 
            'rating_agency' => $this->faker->randomElement(["Moody's", "S&P", "Fitch"]),
            'effective_date' => $this->faker->date(), // Y-m-d format
            'rating_tenure' => $this->faker->numberBetween(6, 60),
            'rating' => $this->faker->randomElement(['AAA', 'AA+', 'BBB-']),
            'rating_action' => $this->faker->randomElement(['Upgrade', 'Downgrade']),
            'rating_outlook' => $this->faker->randomElement(['Stable', 'Negative']),
            'rating_watch' => $this->faker->randomElement(['Positive Watch', 'Negative Watch']),
        ];
    }
}