<?php

namespace Database\Factories;

use App\Models\BondInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class BondInfoFactory extends Factory
{
    protected $model = BondInfo::class;

    public function definition()
    {
        $issueDate = $this->faker->dateTimeBetween('-5 years', 'now');
        
        return [
            'bond_id' => \App\Models\Bond::factory(),
            'principal' => $this->faker->randomFloat(2, 1000000, 5000000),
            'islamic_concept' => $this->faker->randomElement(['Murabaha','Ijara','Sukuk Al-Ijara','Mudaraba','Musharaka']),
            'isin_code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{10}'),
            'stock_code' => $this->faker->bothify('??##??'),
            'instrument_code' => $this->faker->bothify('INST-#####'),
            'category' => $this->faker->randomElement(['Government', 'Corporate', 'Sukuk']),
            'sub_category' => $this->faker->randomElement(['Treasury', 'Bonds', 'Notes']),
            'issue_date' => $issueDate,
            'maturity_date' => $this->faker->dateTimeBetween($issueDate, '+10 years')->format('Y-m-d'),
            'coupon_rate' => $this->faker->randomFloat(2, 0, 10),
            'coupon_type' => $this->faker->randomElement(['Fixed', 'Floating']),
            'coupon_frequency' => $this->faker->randomElement(['Monthly', 'Quarterly', 'Semi-Annual', 'Annual']),
            'day_count' => $this->faker->randomElement(['30/360', 'Actual/360', 'Actual/Actual']),
            'issue_tenure_years' => $this->faker->numberBetween(5, 30),
            'residual_tenure_years' => $this->faker->numberBetween(1, 10),
            'last_traded_yield' => $this->faker->randomFloat(2, 1, 10),
            'last_traded_price' => $this->faker->randomFloat(4, 90, 120),
            'last_traded_amount' => $this->faker->randomFloat(2, 100000, 500000),
            'last_traded_date' => $this->faker->date(),
            'coupon_accrual' => $this->faker->randomFloat(2, 0, 1000),
            'prev_coupon_payment_date' => $this->faker->date(),
            'first_coupon_payment_date' => $this->faker->date(),
            'next_coupon_payment_date' => $this->faker->date(),
            'last_coupon_payment_date' => $this->faker->date(),
            'amount_issued' => $this->faker->randomFloat(2, 1000000, 5000000),
            'amount_outstanding' => $this->faker->randomFloat(2, 500000, 1000000),
            'lead_arranger' => $this->faker->company,
            'facility_agent' => $this->faker->company,
            'facility_code' => 'FAC-' . $this->faker->unique()->bothify('??##'),
        ];
    }
}