<?php

namespace Database\Factories;

use App\Models\Issuer;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssuerFactory extends Factory
{
    protected $model = Issuer::class;

    public function definition()
    {
        // Generate a base date for relationship consistency
        $trustDeedDate = $this->faker->dateTimeBetween('-5 years', 'now');

        return [
            'issuer_short_name' => $this->faker->unique()->company,
            'issuer_name' => $this->faker->company,
            'registration_number' => $this->faker->unique()->randomNumber(8),
            'debenture' => $this->faker->word,
            
            // Financial fields
            'trustee_fee_amount_1' => $this->faker->randomFloat(2, 1000, 100000),
            'trustee_fee_amount_2' => $this->faker->randomFloat(2, 1000, 100000),
            
            // Trustee roles
            'trustee_role_1' => $this->faker->jobTitle,
            'trustee_role_2' => $this->faker->jobTitle,
            
            // Updated reminder dates (related to trust deed date)
            'reminder_1' => $this->faker->dateTimeBetween(
                $trustDeedDate, 
                $trustDeedDate->modify('+6 months')
            )->format('Y-m-d'),
            
            'reminder_2' => $this->faker->dateTimeBetween(
                $trustDeedDate, 
                $trustDeedDate->modify('+1 year')
            )->format('Y-m-d'),
            
            'reminder_3' => $this->faker->dateTimeBetween(
                $trustDeedDate, 
                $trustDeedDate->modify('+2 years')
            )->format('Y-m-d'),
            
            // Trust deed date
            'trust_deed_date' => $trustDeedDate->format('Y-m-d')
        ];
    }
}