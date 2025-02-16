<?php

namespace Database\Factories;

use App\Models\PaymentSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentScheduleFactory extends Factory
{
    protected $model = PaymentSchedule::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
        
        return [
            'start_date' => $startDate,
            'end_date' => Carbon::parse($startDate)->addMonths(6)->format('Y-m-d'),
            'payment_date' => Carbon::parse($startDate)->addMonths(6)->addDays(5)->format('Y-m-d'),
            'ex_date' => Carbon::parse($startDate)->addMonths(6)->subDays(2),
            'coupon_rate' => $this->faker->randomFloat(2, 1, 10),
            'bond_id' => \App\Models\Bond::factory(),
        ];
    }
}
