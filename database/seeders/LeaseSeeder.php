<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Property;
use App\Models\Portfolio;
use App\Models\Tenant;
use App\Models\Lease;

class LeaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // get all tenants
        $tenants = Tenant::all();

        // Loop through each tenant and create leases
        foreach ($tenants as $tenant) {
            for ($i = 1; $i <= 3; $i++) {
                // Options for renewal: null, 1 year, 2 years, or 3 years
                $renewalOptions = [null, '1 year', '2 years', '3 years'];
                $renewalOption = $renewalOptions[array_rand($renewalOptions)];
                
                // Base rates for each year with up to a maximum 8% increase
                $baseRateYear1 = 1000 + ($i * 100);
                $increasePercentage = rand(3, 8); // Random increase between 3% and 8%
                $baseRateYear2 = round($baseRateYear1 * (1 + ($increasePercentage / 100)), 2);
                $baseRateYear3 = round($baseRateYear2 * (1 + ($increasePercentage / 100)), 2);
                
                // Monthly GSTO for each year with up to a maximum 8% increase
                $monthlyGstoYear1 = 200 + ($i * 50);
                $gstoIncreasePercentage = rand(3, 8); // Random increase between 3% and 8%
                $monthlyGstoYear2 = round($monthlyGstoYear1 * (1 + ($gstoIncreasePercentage / 100)), 2);
                $monthlyGstoYear3 = round($monthlyGstoYear2 * (1 + ($gstoIncreasePercentage / 100)), 2);
                
                // Make 2 active and 1 pending
                $status = ($i < 3) ? 'active' : 'pending';
                
                // Set verification information based on status
                $verifiedBy = ($status == 'active') ? 'System Verifier' : null;
                $approvalDatetime = ($status == 'active') ? Carbon::now() : null;
                
                Lease::create([
                    'tenant_id' => $tenant->id,
                    'lease_name' => 'Lease Agreement ' . $i . ' - ' . $tenant->name,
                    'demised_premises' => 'Unit ' . $i . ', Building A',
                    'permitted_use' => 'Commercial Office Space',
                    'option_to_renew' => $renewalOption,
                    'term_years' => rand(1, 5),
                    'start_date' => Carbon::now()->subMonths($i),
                    'end_date' => Carbon::now()->addYears(rand(1, 3)),
                    'base_rate_year_1' => $baseRateYear1,
                    'monthly_gsto_year_1' => $monthlyGstoYear1,
                    'remarks_year_1' => 'Year 1 terms applied',
                    'base_rate_year_2' => $baseRateYear2,
                    'monthly_gsto_year_2' => $monthlyGstoYear2,
                    'remarks_year_2' => "Year 2 terms with {$increasePercentage}% increase",
                    'base_rate_year_3' => $baseRateYear3,
                    'monthly_gsto_year_3' => $monthlyGstoYear3,
                    'remarks_year_3' => "Year 3 terms with {$increasePercentage}% increase",
                    'space' => 100.00 * $i,
                    'tenancy_type' => $i % 2 == 0 ? 'New' : 'Renewal',
                    'attachment' => null,
                    'status' => $status,
                    'prepared_by' => 'System Admin',
                    'verified_by' => $verifiedBy,
                    'approval_datetime' => $approvalDatetime,
                ]);
            }
        }
    }
}