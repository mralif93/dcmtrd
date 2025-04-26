<?php

namespace Database\Seeders;

use App\Models\ApprovalProperty;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApprovalPropertySeeder extends Seeder
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
        
        // Sample description prefixes
        $descriptionPrefixes = [
            'Approval for property renovation of ',
            'Property assessment and valuation for ',
            'Major repairs authorization for ',
            'Property improvement plan for ',
            'Maintenance schedule approval for ',
            'Property expansion project at ',
            'Security enhancement project for ',
            'Landscaping project approval for ',
            'Utility system upgrade for ',
            'Interior remodeling approval for '
        ];

        // Sample description suffixes
        $descriptionSuffixes = [
            'to increase property value.',
            'to comply with local regulations.',
            'to enhance tenant satisfaction.',
            'to address safety concerns.',
            'to improve energy efficiency.',
            'to modernize facilities.',
            'to add additional capacity.',
            'to prepare for seasonal changes.',
            'to address tenant complaints.',
            'to meet environmental standards.'
        ];

        // Create 30 approval property records
        for ($i = 0; $i < 30; $i++) {
            $dateOfApproval = Carbon::now()->subDays(rand(1, 365));
            $status = $statuses[array_rand($statuses)];
            
            // For active or rejected statuses, set approval date
            $approvalDatetime = null;
            if (in_array($status, ['active', 'rejected'])) {
                $approvalDatetime = $dateOfApproval->copy()->addDays(rand(1, 14));
            }
            
            // Generate a realistic description
            $description = $descriptionPrefixes[array_rand($descriptionPrefixes)] 
                . 'property #' . rand(100, 999) 
                . ' ' 
                . $descriptionSuffixes[array_rand($descriptionSuffixes)] 
                . ' ' 
                . Str::random(20);
            
            // Generate a realistic estimated amount between $1,000 and $500,000
            $estimatedAmount = rand(100000, 50000000) / 100;
            
            ApprovalProperty::create([
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'date_of_approval' => $dateOfApproval,
                'description' => $description,
                'estimated_amount' => $estimatedAmount,
                'attachment' => (rand(0, 1)) ? 'attachments/approval_' . ($i + 1) . '.pdf' : null,
                'status' => $status,
                'prepared_by' => $names[array_rand($names)],
                'verified_by' => (rand(0, 1)) ? $names[array_rand($names)] : null,
                'remarks' => (rand(0, 1)) ? 'Property approval remarks. ' . Str::random(30) : null,
                'approval_datetime' => $approvalDatetime,
            ]);
        }
    }
}