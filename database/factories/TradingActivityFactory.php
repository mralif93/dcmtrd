<?php

namespace Database\Factories;

use App\Models\BondInfo;
use App\Models\TradingActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradingActivityFactory extends Factory
{
    protected $model = TradingActivity::class;

    public function definition()
    {
        $bondInfo = BondInfo::inRandomOrder()->first() ?? BondInfo::factory()->create();
        $tradeDate = $this->faker->dateTimeBetween('-1 year');

        return [
            'bond_info_id' => $bondInfo->id,
            'trade_date' => $tradeDate,
            'input_time' => $this->faker->time(),
            'amount' => $this->faker->randomFloat(2, 0.1, 100), // RM 0.1M to RM 100M
            'price' => $this->faker->randomFloat(4, 90, 120), // 90.0000 to 120.0000
            'yield' => $this->faker->randomFloat(2, 0, 20), // 0.00% to 20.00%
            'value_date' => Carbon::parse($tradeDate)->addDays(2)->format('Y-m-d'), // T+2 settlement
        ];
    }
}