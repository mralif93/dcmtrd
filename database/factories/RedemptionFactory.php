<?php

namespace Database\Factories;

use App\Models\BondInfo;
use App\Models\Redemption;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedemptionFactory extends Factory
{
    protected $model = Redemption::class;

    public function definition()
    {
        // Use an existing BondInfo or create a new one
        $bondInfo = BondInfo::inRandomOrder()->first() ?? BondInfo::factory()->create();

        return [
            'bond_info_id' => $bondInfo->id,
            'allow_partial_call' => $this->faker->boolean(30), // 30% chance of true
            'redeem_nearest_denomination' => $this->faker->boolean(20), // 20% chance of true
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Redemption $redemption) {
            // Generate last_call_date between bond's issue_date and 3 months before maturity
            $bondInfo = $redemption->bondInfo;
            $maturityDateMinus3Months = Carbon::parse($bondInfo->maturity_date)->subMonths(3);
            
            $redemption->last_call_date = $this->faker->dateTimeBetween(
                $bondInfo->issue_date,
                $maturityDateMinus3Months
            )->format('Y-m-d');
        });
    }
}