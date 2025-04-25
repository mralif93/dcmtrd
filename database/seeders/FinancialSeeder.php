<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

// Models
use App\Models\FinancialType;
use App\Models\Bank;
use App\Models\Portfolio;
use App\Models\Property;
use App\Models\Financial;

class FinancialSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get all portfolios
        $portfolios = Portfolio::all();
        
        // Get banks and financial types
        $banks = Bank::all();
        $financialTypes = FinancialType::all();
        
        // Loop through each portfolio and create financials
        foreach ($portfolios as $portfolio) {
            // Get properties associated with this portfolio
            $properties = Property::where('portfolio_id', $portfolio->id)->get();
            
            for ($i = 1; $i <= 3; $i++) {
                $totalAmount = 100000 * $i;
                $utilizationAmount = 75000 * $i;
                $outstandingAmount = 50000 * $i;
                $profitRate = 5.5 + ($i * 0.5);
                
                // Create the financial record
                $financial = Financial::create([
                    'portfolio_id' => $portfolio->id,
                    'bank_id' => $banks->random()->id,
                    'financial_type_id' => $financialTypes->random()->id,
                    'batch_no' => 'BATCH-' . $portfolio->id . $i,
                    'purpose' => 'Financial Purpose ' . $i . ' for Portfolio ' . $portfolio->id,
                    'tenure' => ($i * 12) . ' months',
                    'installment_date' => $i . ' Monthly',
                    'profit_type' => $i % 2 == 0 ? 'Fixed' : 'Variable',
                    'profit_rate' => $profitRate,
                    'process_fee' => 1000 * $i,
                    'total_facility_amount' => $totalAmount,
                    'utilization_amount' => $utilizationAmount,
                    'outstanding_amount' => $outstandingAmount,
                    'interest_monthly' => ($outstandingAmount * $profitRate / 100) / 12,
                    'security_value_monthly' => 5000 * $i,
                    'facilities_agent' => 'Agent ' . $i,
                    'agent_contact' => '123-456-789' . $i,
                    'valuer' => 'Valuer Company ' . $i,
                    'status' => 'pending',
                    'prepared_by' => 'System Admin',
                    'verified_by' => 'System Verifier',
                    'approval_datetime' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                
                // Associate properties with this financial record if there are any
                if ($properties->isNotEmpty()) {
                    // Get up to 2 random properties from the same portfolio
                    $propertiesToAttach = $properties->random(min(2, $properties->count()));
                    
                    foreach ($propertiesToAttach as $property) {
                        // Calculate some reasonable values based on the property and financial data
                        $propertyValue = $property->property_value ?? rand(500000, 2000000);
                        $financedAmount = min($propertyValue * 0.7, $totalAmount);
                        $securityValue = $propertyValue * 0.8;
                        
                        // Attach the property with the pivot table data
                        $financial->properties()->attach($property->id, [
                            'property_value' => $propertyValue,
                            'financed_amount' => $financedAmount,
                            'security_value' => $securityValue,
                            'valuation_date' => Carbon::now()->subDays(rand(10, 60)),
                            'remarks' => 'Property financing for ' . $property->name ?? 'Property #' . $property->id,
                            'status' => 'pending',
                            'prepared_by' => 'System Admin',
                            'verified_by' => 'System Verifier',
                            'approval_datetime' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }
    }
}