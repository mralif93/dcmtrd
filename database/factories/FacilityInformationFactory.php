<?php

namespace Database\Factories;

use App\Models\FacilityInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityInformationFactory extends Factory
{
    protected $model = FacilityInformation::class;

    public function definition()
    {
        return [
            'issuer_id' => \App\Models\Issuer::factory(),
            'facility_code' => 'FAC-' . $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'facility_number' => $this->faker->unique()->numerify('FN-#####'),
            'facility_name' => $this->faker->company . ' Facility',
            'principal_type' => $this->faker->randomElement(['Senior Debt', 'Subordinated Debt', 'Equity']),
            'islamic_concept' => $this->faker->optional()->randomElement(['Murabaha', 'Sukuk', 'Ijara']),
            'maturity_date' => $this->faker->dateTimeBetween('+1 year', '+10 years')->format('Y-m-d'),
            'instrument' => $this->faker->randomElement(['Loan', 'Bond', 'Sukuk']),
            'instrument_type' => $this->faker->randomElement(['Sukuk', 'Conventional', 'Hybrid']),
            'guaranteed' => $this->faker->boolean(30),
            'total_guaranteed' => $this->faker->randomFloat(2, 100000, 5000000),
            'indicator' => $this->faker->randomElement(['Performing', 'Non-Performing', 'Restructured']),
            'facility_rating' => $this->faker->randomElement(['AAA', 'A+', 'BBB-', 'BB']),
            'facility_amount' => $this->faker->randomFloat(2, 1000000, 50000000),
            'available_limit' => $this->faker->randomFloat(2, 0, 10000000),
            'outstanding_amount' => $this->faker->randomFloat(2, 0, 5000000),
            'trustee_security_agent' => $this->faker->company,
            'lead_arranger' => $this->faker->company,
            'facility_agent' => $this->faker->company,
            'availability_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}