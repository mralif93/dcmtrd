<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioType;

class PortfolioTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolioTypes = [
            [
                'name' => 'Real Estate',
                'description' => 'Properties including residential, commercial, and industrial buildings.',
            ],
            [
                'name' => 'Healthcare Facilities',
                'description' => 'Hospitals, clinics, and wellness centers under management.',
            ],
            [
                'name' => 'Retail Spaces',
                'description' => 'Shopping malls and retail properties leased to tenants.',
            ],
            [
                'name' => 'Office Buildings',
                'description' => 'Corporate office spaces and business hubs.',
            ],
        ];

        foreach ($portfolioTypes as $type) {
            PortfolioType::create($type);
        }
    }
}
