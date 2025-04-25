<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\Tenant;

class ChecklistTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing checklist IDs
        $checklistIds = Checklist::pluck('id')->toArray();
        
        // If no checklists exist, create a warning
        if (empty($checklistIds)) {
            $this->command->warn('No checklists found in the database. Please run the ChecklistSeeder first.');
            return;
        }
        
        // Get all existing tenant IDs
        $tenantIds = Tenant::pluck('id')->toArray();
        
        // If no tenants exist, create a warning
        if (empty($tenantIds)) {
            $this->command->warn('No tenants found in the database. Please run the TenantSeeder first.');
            return;
        }
        
        // Status options
        $statusOptions = ['pending', 'in_progress', 'completed', 'verified', 'rejected'];
        
        // Staff members who might prepare or verify checklists
        $staffMembers = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Lisa Anderson',
            'Robert Wilson'
        ];
        
        // Create 50 checklist_tenant records
        $checklistTenantData = [];
        
        for ($i = 0; $i < 50; $i++) {
            // Get random checklist and tenant
            $checklistId = $checklistIds[array_rand($checklistIds)];
            $tenantId = $tenantIds[array_rand($tenantIds)];
            
            // Generate a random status
            $status = $statusOptions[array_rand($statusOptions)];
            
            // Determine prepared_by and verified_by based on status
            $preparedBy = $status !== 'pending' ? $staffMembers[array_rand($staffMembers)] : null;
            $verifiedBy = in_array($status, ['verified', 'rejected']) ? $staffMembers[array_rand($staffMembers)] : null;
            
            // Generate appropriate dates
            $createdAt = Carbon::now()->subDays(rand(1, 90));
            $updatedAt = $createdAt->copy()->addDays(rand(0, 30));
            $approvalDateTime = in_array($status, ['verified', 'completed']) ? 
                $updatedAt->copy()->addDays(rand(1, 5)) : null;
            
            // Prepare the record
            $checklistTenantData[] = [
                'checklist_id' => $checklistId,
                'tenant_id' => $tenantId,
                'notes' => $this->generateRandomNotes(),
                'status' => $status,
                'prepared_by' => $preparedBy,
                'verified_by' => $verifiedBy,
                'remarks' => $status !== 'pending' ? $this->generateRandomRemarks($status) : null,
                'approval_datetime' => $approvalDateTime,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'deleted_at' => rand(1, 10) === 1 ? $updatedAt->copy()->addDays(rand(1, 30)) : null, // ~10% chance of being soft deleted
            ];
        }
        
        // Insert the data using model creation instead of DB facade
        foreach ($checklistTenantData as $data) {
            \App\Models\ChecklistTenant::create($data);
        }
    }
    
    /**
     * Generate random notes
     */
    private function generateRandomNotes(): ?string
    {
        // 30% chance of having no notes
        if (rand(1, 100) <= 30) {
            return null;
        }
        
        $noteTemplates = [
            'Initial inspection completed on property.',
            'Tenant requested additional time to complete checklist items.',
            'Several issues found during inspection that need addressing.',
            'All requirements met according to the property guidelines.',
            'Follow-up inspection scheduled for next month.',
            'Maintenance team notified about required repairs.',
            'Waiting for tenant confirmation on completed items.',
            'Property manager approved all checklist items.',
            'Documentation provided by tenant for all completed items.',
            'Security deposit adjustments may be required based on findings.'
        ];
        
        return $noteTemplates[array_rand($noteTemplates)];
    }
    
    /**
     * Generate random remarks based on status
     */
    private function generateRandomRemarks(string $status): ?string
    {
        // 40% chance of having no remarks
        if (rand(1, 100) <= 40) {
            return null;
        }
        
        $remarkTemplates = [
            'pending' => [
                'Waiting for tenant response.',
                'Scheduled for review next week.',
                'Initial documentation received.'
            ],
            'in_progress' => [
                'Tenant working on completing required items.',
                'Partial documentation received.',
                'Regular updates being provided by tenant.'
            ],
            'completed' => [
                'All items marked as completed by tenant.',
                'Documentation verified for all items.',
                'Waiting for final property manager approval.'
            ],
            'verified' => [
                'All requirements satisfied.',
                'Property in excellent condition.',
                'Tenant compliance verified and approved.'
            ],
            'rejected' => [
                'Multiple items failed inspection.',
                'Insufficient documentation provided.',
                'Property condition does not meet standards.'
            ]
        ];
        
        $applicableRemarks = $remarkTemplates[$status] ?? $remarkTemplates['pending'];
        return $applicableRemarks[array_rand($applicableRemarks)];
    }
}