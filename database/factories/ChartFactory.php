<?php

namespace Database\Factories;

use App\Models\Chart;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartFactory extends Factory
{
    protected $model = Chart::class;

    public function definition()
    {
        $periodFrom = $this->faker->dateTimeBetween('-1 year', 'now');
        $periodTo = $this->faker->dateTimeBetween($periodFrom, '+1 year');

        return [
            'bond_id' => \App\Models\Bond::factory(),
            'chart_type' => $this->faker->randomElement(['line', 'bar', 'pie']),
            'chart_data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                'values' => $this->faker->randomElements(range(100, 1000), 5),
            ],
            'period_from' => $periodFrom,
            'period_to' => $periodTo,
        ];
    }
}