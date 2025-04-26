<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Portfolio;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, make sure we have some portfolios to reference
        $portfolioIds = Portfolio::pluck('id')->toArray();
        
        // If no portfolios exist, create at least one dummy portfolio
        if (empty($portfolioIds)) {
            $this->command->info('No portfolios found. Creating a sample portfolio.');
            
            $portfolio = Portfolio::create([
                'name' => 'Sample Portfolio',
            ]);
            
            $portfolioIds = [$portfolio->id];
        }
        
        // Sample data for party names
        $partyNames = [
            'Acme Corporation', 
            'Globex Industries', 
            'Wayne Enterprises', 
            'Stark Industries', 
            'Umbrella Corporation',
            'Oscorp Industries',
            'Massive Dynamic',
            'Soylent Corp',
            'Cyberdyne Systems',
            'Initech'
        ];
        
        // Sample data for descriptions
        $descriptions = [
            'Quarterly budget review meeting',
            'Project kickoff discussion',
            'Contract negotiation session',
            'Investment opportunity presentation',
            'Annual partnership renewal',
            'Product demonstration',
            'Service agreement finalization',
            'Merger discussion',
            'Supply chain optimization',
            'Technology upgrade consultation'
        ];
        
        // Sample data for status options
        $statusOptions = ['active', 'pending', 'rejected', 'inactive'];
        
        // Sample data for staff names
        $staffNames = [
            'John Doe', 
            'Jane Smith', 
            'Robert Johnson', 
            'Emily Davis', 
            'Michael Wilson'
        ];
        
        // Generate 50 appointments
        for ($i = 0; $i < 50; $i++) {
            $status = $statusOptions[array_rand($statusOptions)];
            $dateOfApproval = Carbon::now()->subDays(rand(1, 365));
            
            // Determine approval datetime based on status
            $approvalDatetime = null;
            if (in_array($status, ['active', 'rejected'])) {
                $approvalDatetime = Carbon::parse($dateOfApproval)->addHours(rand(1, 72));
            }
            
            $appointment = Appointment::create([
                'portfolio_id' => $portfolioIds[array_rand($portfolioIds)],
                'date_of_approval' => $dateOfApproval->format('Y-m-d'),
                'party_name' => $partyNames[array_rand($partyNames)],
                'description' => $descriptions[array_rand($descriptions)] . ' - ' . Str::random(20),
                'estimated_amount' => rand(1000, 1000000) / 100,
                'attachment' => rand(0, 1) ? 'documents/appointment_' . ($i + 1) . '.pdf' : null,
                'status' => $status,
                'prepared_by' => $staffNames[array_rand($staffNames)],
                'verified_by' => rand(0, 1) ? $staffNames[array_rand($staffNames)] : null,
                'remarks' => rand(0, 1) ? 'Additional notes: ' . Str::random(50) : null,
                'approval_datetime' => $approvalDatetime,
                'created_at' => Carbon::now()->subDays(rand(1, 400)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
            
            // Apply soft delete to ~10% of records
            if (rand(1, 10) > 9) {
                $appointment->delete();
            }
        }
    }
}