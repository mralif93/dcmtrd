<?php

namespace Database\Factories;

use App\Models\Issuer;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssuerFactory extends Factory
{
    protected $model = Issuer::class;

    public function definition()
    {
        return [
            'issuer_short_name' => $this->faker->companySuffix,
            'issuer_name' => $this->faker->company,
            'registration_number' => $this->faker->unique()->regexify('REG-[A-Z0-9]{10}'),
            'debenture' => $this->faker->text(20),
            'trustee_fee_amount_1' => $this->faker->randomFloat(2, 1000, 100000),
            'trustee_fee_amount_2' => $this->faker->randomFloat(2, 1000, 100000),
            'trustee_role_1' => $this->faker->jobTitle,
            'trustee_role_2' => $this->faker->jobTitle,
            'reminder_1' => $this->faker->optional()->date(),
            'reminder_2' => $this->faker->optional()->date(),
            'reminder_3' => $this->faker->optional()->date(),
            'trust_deed_date' => $this->faker->date(),
        ];
    }
}