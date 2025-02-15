<?php

namespace Database\Factories;

use App\Models\LockoutPeriod;
use App\Models\Redemption;
use Illuminate\Database\Eloquent\Factories\Factory;

class LockoutPeriodFactory extends Factory
{
    protected $model = LockoutPeriod::class;

    public function definition()
    {
        return [
            'redemption_id' => Redemption::factory(),
            'start_date' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'end_date' => $this->faker->dateTimeBetween('-11 months', '+6 months'),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (LockoutPeriod $lockoutPeriod) {
            // Ensure end_date is after start_date
            if ($lockoutPeriod->end_date <= $lockoutPeriod->start_date) {
                $lockoutPeriod->end_date = $this->faker->dateTimeBetween(
                    $lockoutPeriod->start_date,
                    '+6 months'
                );
            }
        });
    }
}