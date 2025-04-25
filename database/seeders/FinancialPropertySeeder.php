<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Property;
use App\Models\FinancialProperty;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FinancialPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing financials and properties
        $financialIds = Financial::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        // Sample statuses
        $statuses = [
            'active',
            'pending',
            'rejected',
            'inactive'
        ];

        // Sample names for prepared_by and verified_by
        $names = [
            'John Doe',
            'Jane Smith',
            'Robert Johnson',
            'Emily Davis',
            'Michael Brown',
            'Sarah Miller',
            'David Wilson',
            'Linda Garcia',
            'William Taylor',
            'Jennifer Anderson'
        ];

        // Create 40 financial property records
        for ($i = 0; $i < 40; $i++) {
            // Make realistic property values between $100,000 and $5,000,000
            $propertyValue = rand(10000000, 500000000) / 100;
            
            // Make financed amount between 50% and 90% of property value
            $financedAmount = $propertyValue * (rand(50, 90) / 100);
            
            // Make security value between 80% and 120% of financed amount
            $securityValue = $financedAmount * (rand(80, 120) / 100);
            
            // Valuation date within the past 2 years
            $valuationDate = Carbon::now()->subDays(rand(1, 730));
            
            $status = $statuses[array_rand($statuses)];
            
            // For active or rejected statuses, set approval date
            $approvalDatetime = null;
            if (in_array($status, ['active', 'rejected'])) {
                $approvalDatetime = $valuationDate->copy()->addDays(rand(1, 30));
            }
            
            // Ensure we have financial IDs and property IDs before creating records
            if (!empty($financialIds) && !empty($propertyIds)) {
                FinancialProperty::create([
                    'financial_id' => $financialIds[array_rand($financialIds)],
                    'property_id' => $propertyIds[array_rand($propertyIds)],
                    'property_value' => $propertyValue,
                    'financed_amount' => $financedAmount,
                    'security_value' => $securityValue,
                    'valuation_date' => $valuationDate,
                    'status' => $status,
                    'prepared_by' => $names[array_rand($names)],
                    'verified_by' => (rand(0, 1)) ? $names[array_rand($names)] : null,
                    'remarks' => (rand(0, 1)) ? 'Property valuation and financing remarks. ' . Str::random(30) : null,
                    'approval_datetime' => $approvalDatetime,
                ]);
            }
        }
    }
}