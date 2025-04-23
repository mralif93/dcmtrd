<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Property;
use App\Models\SiteVisit;

class SiteVisitSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get all properties
        $properties = Property::all();

        // Loop through each property and create site visits
        foreach ($properties as $property) {
            for ($i = 1; $i <= 3; $i++) {
                // Create site visit with fields matching the schema
                SiteVisit::create([
                    'property_id' => $property->id,
                    'date_visit' => Carbon::now()->subDays($i * 7),
                    'time_visit' => sprintf('%02d:00:00', 9 + $i),
                    'trustee' => 'Trustee ' . $i,
                    'manager' => 'Manager ' . $i,
                    'maintenance_manager' => 'Maintenance Manager ' . $i,
                    'building_manager' => 'Building Manager ' . $i,
                    'notes' => 'Site inspection notes for Property ' . $property->id . ' - Visit ' . $i,
                    'submission_date' => Carbon::now()->subDays($i * 7 - 1),
                    'follow_up_required' => ($i % 2 == 0),
                    'attachment' => null,
                    'status' => 'pending',
                    'prepared_by' => 'System Admin',
                    'verified_by' => 'System Verifier',
                    'approval_datetime' => Carbon::now(),
                ]);
            }
        }
    }
}