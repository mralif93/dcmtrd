<?php

namespace Database\Factories;

use App\Models\Chart;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartFactory extends Factory
{
    protected $model = Chart::class;

    public function definition()
    {
        return [
            'availability_date' => $this->faker->date(),
            'approval_date_time' => $this->faker->dateTime(),
            'chart_type' => $this->faker->randomElement(['line', 'bar', 'pie']),
            'chart_data' => json_encode([
                'labels' => ['Jan', 'Feb', 'Mar'],
                'datasets' => [
                    [
                        'data' => [rand(1,100), rand(1,100), rand(1,100)],
                        'label' => 'Sample Data'
                    ]
                ]
            ]),
            'period_from' => $this->faker->date(),
            'period_to' => $this->faker->date(),
            'bond_id' => \App\Models\Bond::factory(),
        ];
    }
}