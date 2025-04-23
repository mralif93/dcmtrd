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

        // Loop through each property and create tenants
        foreach ($properties as $property) {
            for ($i = 1; $i <= 5; $i++) {
                Tenant::create([
                    'property_id' => $property->id,
                    'name' => 'Tenant ' . $i . ' for Property ' . $property->id,
                    'contact_person' => 'Contact Person ' . $i,
                    'email' => 'tenant' . $i . '@example.com',
                    'phone' => '123-456-789' . $i,
                    'commencement_date' => Carbon::now()->subMonths($i),
                    'approval_date' => Carbon::now()->subMonths($i)->addDays(10),
                    'expiry_date' => Carbon::now()->addYears(1),
                    'status' => 'active',
                    'prepared_by' => 'System Admin',
                    'verified_by' => 'System Verifier',
                    'approval_datetime' => Carbon::now(),
                ]);
            }
        }
    }
}