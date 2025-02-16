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
            'facility_code' => $this->faker->unique()->regexify('FAC-[A-Z0-9]{10}'),
            'facility_number' => $this->faker->unique()->numerify('FN###'),
            'facility_name' => $this->faker->word . ' Facility',
            'principle_type' => $this->faker->randomElement(['Islamic', 'Conventional']),
            'islamic_concept' => $this->faker->randomElement(['Murabahah', 'Ijara', 'Sukuk']),
            'maturity_date' => $this->faker->date(),
            'instrument' => $this->faker->word,
            'instrument_type' => $this->faker->word,
            'guaranteed' => $this->faker->boolean,
            'total_guaranteed' => $this->faker->randomFloat(2, 100000, 1000000),
            'indicator' => $this->faker->randomLetter,
            'facility_rating' => $this->faker->randomElement(['AAA', 'AA', 'A']),
            'facility_amount' => $this->faker->randomFloat(2, 1000000, 10000000),
            'available_limit' => $this->faker->randomFloat(2, 0, 1000000),
            'outstanding_amount' => $this->faker->randomFloat(2, 0, 1000000),
            'trustee_security_agent' => $this->faker->company,
            'lead_arranger' => $this->faker->company,
            'facility_agent' => $this->faker->company,
            'availability_date' => $this->faker->date(),
            'issuer_id' => \App\Models\Issuer::factory(),
        ];
    }
}
