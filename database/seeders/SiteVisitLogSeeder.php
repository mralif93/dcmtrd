<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\SiteVisitLog;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SiteVisitLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing properties
        $propertyIds = Property::pluck('id')->toArray();
        
        if (empty($propertyIds)) {
            $this->command->info('No property records found. Please seed the properties table first.');
            return;
        }

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
        
        // Sample purpose prefixes
        $purposePrefixes = [
            'Regular inspection of ',
            'Maintenance check for ',
            'Property assessment at ',
            'Tenant complaint follow-up at ',
            'Security evaluation of ',
            'Environmental compliance check for ',
            'Utility systems review at ',
            'Renovation progress check for ',
            'Insurance claim verification for ',
            'Damage assessment after incident at '
        ];

        // Sample purpose suffixes
        $purposeSuffixes = [
            'to ensure property standards are maintained.',
            'to address reported issues with plumbing system.',
            'to verify recent repairs and improvements.',
            'to check structural integrity after storm.',
            'to evaluate tenant satisfaction with facilities.',
            'to document current condition for portfolio records.',
            'to assess parking facilities and accessibility.',
            'to review landscaping and exterior maintenance needs.',
            'to inspect HVAC systems before summer season.',
            'to verify compliance with building codes.'
        ];
        
        // Sample categories
        $categories = [
            'Routine Inspection',
            'Maintenance',
            'Emergency',
            'Tenant Request',
            'Insurance',
            'Compliance',
            'Renovation',
            'Security',
            'Environmental',
            'Other'
        ];

        // Create 60 site visit log records spanning the last 3 years
        for ($i = 0; $i < 60; $i++) {
            // Generate a random date within the last 3 years
            $visitDate = Carbon::now()->subDays(rand(1, 1095));
            
            $status = $statuses[array_rand($statuses)];
            
            // For active or rejected statuses, set approval date
            $approvalDatetime = null;
            if (in_array($status, ['active', 'rejected'])) {
                $approvalDatetime = $visitDate->copy()->addDays(rand(1, 7));
            }
            
            // Generate a realistic purpose
            $purpose = $purposePrefixes[array_rand($purposePrefixes)] 
                . 'property #' . rand(100, 999) 
                . ' ' 
                . $purposeSuffixes[array_rand($purposeSuffixes)];
            
            SiteVisitLog::create([
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'visit_day' => $visitDate->format('d'),
                'visit_month' => $visitDate->format('m'),
                'visit_year' => $visitDate->format('Y'),
                'purpose' => $purpose,
                'category' => $categories[array_rand($categories)],
                'status' => $status,
                'prepared_by' => $names[array_rand($names)],
                'verified_by' => (rand(0, 1)) ? $names[array_rand($names)] : null,
                'remarks' => (rand(0, 1)) ? 'Site visit observations and findings. ' . Str::random(30) : null,
                'approval_datetime' => $approvalDatetime,
            ]);
        }
    }
}