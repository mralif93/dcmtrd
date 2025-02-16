<?php

namespace Database\Factories;

use App\Models\Bond;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BondFactory extends Factory
{
    protected $model = Bond::class;

    public function definition()
    {
        $issueDate = $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
        $maturityDate = Carbon::parse($issueDate)->addYears(rand(5, 15));

        return [
            'bond_sukuk_name' => $this->faker->word . ' SUKUK',
            'sub_name' => $this->faker->word,
            'rating' => $this->faker->randomElement(['AAA', 'AA', 'A', 'BBB']),
            'category' => $this->faker->randomElement(['Corporate', 'Government', 'Sukuk']),
            'o_s_amount' => $this->faker->randomFloat(2, 1000000, 100000000),
            'principal' => $this->faker->randomFloat(2, 1000000, 100000000),
            'isin_code' => $this->faker->unique()->regexify('[A-Z0-9]{20}'),
            'stock_code' => $this->faker->unique()->regexify('[A-Z]{6}'),
            'instrument_code' => $this->faker->unique()->regexify('INST[0-9]{6}'),
            'sub_category' => $this->faker->word,
            'issue_date' => $issueDate,
            'maturity_date' => $maturityDate,
            'coupon_rate' => $this->faker->randomFloat(2, 1, 15),
            'coupon_type' => $this->faker->randomElement(['Fixed', 'Floating']),
            'coupon_frequency' => $this->faker->randomElement(['Monthly', 'Quarterly', 'Semi-Annual', 'Annual']),
            'day_count' => '30/360',
            'issue_tenure_years' => $this->faker->numberBetween(5, 30),
            'residual_tenure_years' => $this->faker->numberBetween(0, 30),
            'last_traded_yield' => $this->faker->randomFloat(2, 1, 20),
            'last_traded_price' => $this->faker->randomFloat(2, 50, 200),
            'last_traded_amount' => $this->faker->randomFloat(2, 10000, 1000000),
            'last_traded_date' => $this->faker->date(),
            'ratings' => json_encode(['agency' => 'S&P', 'rating' => 'AA']),
            'coupon_accrual' => $this->faker->randomFloat(2, 1000, 100000),
            'prev_coupon_payment_date' => $this->faker->date(),
            'first_coupon_payment_date' => $this->faker->date(),
            'next_coupon_payment_date' => $this->faker->date(),
            'last_coupon_payment_date' => $this->faker->date(),
            'amount_issued' => $this->faker->randomFloat(2, 1000000, 100000000),
            'amount_outstanding' => $this->faker->randomFloat(2, 1000000, 100000000),
            'lead_arranger' => $this->faker->company,
            'facility_agent' => $this->faker->company,
            'facility_code' => $this->faker->unique()->regexify('BOND-FAC-[A-Z0-9]{8}'),
            'status' => $this->faker->randomElement(['Active', 'Matured', 'Called']),
            'approval_date_time' => $this->faker->dateTime(),
            'issuer_id' => \App\Models\Issuer::factory(),
        ];
    }
}
