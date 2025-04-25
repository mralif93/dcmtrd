<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\SiteVisit;
use App\Models\Checklist;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First ensure we have some site visits to reference
        // Check if we need to seed SiteVisit data first
        if (SiteVisit::count() === 0) {
            $this->command->info('No site visits found. Please run SiteVisitSeeder first.');
            // Alternatively, you could call the SiteVisitSeeder here
            // $this->call(SiteVisitSeeder::class);
            return;
        }

        // Get all site visits
        $siteVisits = SiteVisit::all();
        
        // Define possible status values
        $statuses = ['pending', 'active', 'rejected', 'inactive'];
        
        // Define possible user names for prepared_by and verified_by
        $users = [
            'John Doe', 
            'Jane Smith', 
            'Michael Johnson', 
            'Emily Williams', 
            'Robert Brown', 
            'Sarah Davis'
        ];
        
        $totalChecklists = 0;
        
        // For each site visit, create at least 5 checklists
        foreach ($siteVisits as $siteVisit) {
            // Generate 5 checklists for each site visit
            for ($i = 0; $i < 5; $i++) {
                $status = $statuses[array_rand($statuses)];
                $preparedBy = $users[array_rand($users)];
                
                // Only set verified_by and approval_datetime if status is 'active' or 'rejected'
                $verifiedBy = in_array($status, ['active', 'rejected']) ? $users[array_rand($users)] : null;
                $approvalDatetime = in_array($status, ['active', 'rejected']) ? Carbon::now()->subDays(rand(1, 30)) : null;
                
                // Create the checklist using the model
                $checklist = new Checklist([
                    'site_visit_id' => $siteVisit->id,
                    'status' => $status,
                    'prepared_by' => $preparedBy,
                    'verified_by' => $verifiedBy,
                    'remarks' => $this->generateRemarks($status),
                    'approval_datetime' => $approvalDatetime,
                ]);
                
                // Set timestamps manually to simulate older records
                $checklist->created_at = Carbon::now()->subDays(rand(1, 60));
                $checklist->updated_at = Carbon::now()->subDays(rand(0, 30));
                
                // Randomly soft delete about 10% of records
                if (rand(1, 10) > 9) {
                    $checklist->deleted_at = Carbon::now()->subDays(rand(0, 15));
                }
                
                $checklist->save();
                $totalChecklists++;
            }
        }
    }
    
    /**
     * Generate realistic remarks based on the status
     */
    private function generateRemarks(string $status): ?string
    {
        if (rand(1, 10) > 7) { // 30% chance of having no remarks
            return null;
        }
        
        $pendingRemarks = [
            'Waiting for site visit completion',
            'To be reviewed after inspection',
            'Pending additional documentation',
            'Awaiting team leader approval',
        ];
        
        $activeRemarks = [
            'Currently in use',
            'All items verified and approved',
            'Checklist active and being utilized',
            'Active for current inspection period',
        ];
        
        $rejectedRemarks = [
            'Failed to meet safety requirements',
            'Documentation incomplete',
            'Major issues found during inspection',
            'Requires rework and reinspection',
        ];
        
        $inactiveRemarks = [
            'No longer in use',
            'Outdated checklist version',
            'Replaced by newer version',
            'Site visit canceled or postponed',
        ];
        
        switch ($status) {
            case 'pending':
                return $pendingRemarks[array_rand($pendingRemarks)];
            case 'active':
                return $activeRemarks[array_rand($activeRemarks)];
            case 'rejected':
                return $rejectedRemarks[array_rand($rejectedRemarks)];
            case 'inactive':
                return $inactiveRemarks[array_rand($inactiveRemarks)];
            default:
                return null;
        }
    }
}