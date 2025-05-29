<?php

namespace Database\Seeders;

use App\Models\ApprovalForm;
use App\Models\Portfolio;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApprovalFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing portfolios and properties
        $portfolioIds = Portfolio::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        // Sample categories
        $categories = [
            'Maintenance Request',
            'Renovation Approval',
            'New Unit Addition',
            'Tenant Change',
            'Budget Approval',
            'Insurance Claim',
            'Emergency Repair',
            'Contract Renewal',
            'Utility Service Change',
            'Other'
        ];

        // Sample statuses
        $statuses = [
            'pending',
            'approved',
            'rejected',
            'in_review',
            'postponed'
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

        // Create 50 approval form records
        for ($i = 0; $i < 50; $i++) {
            $receivedDate = Carbon::now()->subDays(rand(1, 90));
            $status = $statuses[array_rand($statuses)];
            
            // For approved or rejected statuses, set approval date
            $approvalDatetime = null;
            if (in_array($status, ['approved', 'rejected'])) {
                $approvalDatetime = $receivedDate->copy()->addDays(rand(1, 14));
            }
            
            // Set send date for some records
            $sendDate = (rand(0, 1)) ? $receivedDate->copy()->addDays(rand(1, 7)) : null;
            
            ApprovalForm::create([
                'portfolio_id' => !empty($portfolioIds) ? $portfolioIds[array_rand($portfolioIds)] : null,
                'property_id' => !empty($propertyIds) ? $propertyIds[array_rand($propertyIds)] : null,
                'category' => $categories[array_rand($categories)],
                'details' => 'This is a sample ' . strtolower($categories[array_rand($categories)]) . ' form with details about the request. ' . Str::random(50),
                'received_date' => $receivedDate,
                'send_date' => $sendDate,
                'attachment' => (rand(0, 1)) ? 'attachments/form_' . ($i + 1) . '.pdf' : null,
                'status' => $status,
                'prepared_by' => $names[array_rand($names)],
                'verified_by' => (rand(0, 1)) ? $names[array_rand($names)] : null,
                'remarks' => (rand(0, 1)) ? 'Sample remarks for this approval form. ' . Str::random(30) : null,
                'approval_datetime' => $approvalDatetime,
            ]);
        }
    }
}