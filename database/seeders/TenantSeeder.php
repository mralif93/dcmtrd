<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Property;
use App\Models\Portfolio;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get all properties
        $properties = Property::all();
        
        $tenantCount = 0;
        
        // Loop through each property and create tenants
        foreach ($properties as $property) {
            for ($i = 1; $i <= 5; $i++) {
                // Increment tenant count
                $tenantCount++;
                
                // Determine status - every even-numbered tenant will be 'pending'
                // This ensures exactly 50% of tenants have 'pending' status
                $status = ($tenantCount % 2 === 0) ? 'pending' : 'active';
                
                // For pending tenants, set approval fields to null
                $approvalDate = $status === 'active' ? Carbon::now()->subMonths($i)->addDays(10) : null;
                $approvalDatetime = $status === 'active' ? Carbon::now() : null;
                $verifiedBy = $status === 'active' ? 'System Verifier' : null;
                
                Tenant::create([
                    'property_id' => $property->id,
                    'name' => 'Tenant ' . $i . ' for Property ' . $property->id,
                    'contact_person' => 'Contact Person ' . $i,
                    'email' => 'tenant' . $i . '@example.com',
                    'phone' => '123-456-789' . $i,
                    'commencement_date' => Carbon::now()->subMonths($i),
                    'approval_date' => $approvalDate,
                    'expiry_date' => Carbon::now()->addYears(1),
                    'status' => $status,
                    'prepared_by' => 'System Admin',
                    'verified_by' => $verifiedBy,
                    'approval_datetime' => $approvalDatetime,
                ]);
            }
        }
    }
}