<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistDisposalInstallation;

class ChecklistDisposalInstallationsSeeder extends Seeder
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
        
        // Status options
        $statusOptions = ['active', 'pending', 'rejected', 'inactive'];
        
        // Staff members who might prepare or verify checklists
        $staffMembers = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Lisa Anderson',
            'Robert Wilson'
        ];
        
        // Disposal component names
        $componentNames = [
            'Trash Compactor',
            'Garbage Chute',
            'Waste Bin System',
            'Recycling Sorter',
            'Compost Bin',
            'Waste Water Treatment',
            'Oil Separator',
            'Chemical Disposal Unit',
            'Hazardous Waste Container',
            'Biomedical Waste Disposal',
            'Electronic Waste Bin',
            'Food Waste Disposer'
        ];
        
        // Scope of work templates
        $scopeOfWorkTemplates = [
            'Complete replacement of existing unit',
            'Installation of new system',
            'Repair of damaged components',
            'Upgrade to meet current standards',
            'Routine maintenance and cleaning',
            'Inspection and certification',
            'Restoration after damage',
            'Efficiency optimization',
            'Capacity expansion',
            'Automation upgrade'
        ];
        
        // Determine how many records to create per checklist (1-3)
        $entriesPerChecklist = [];
        foreach ($checklistIds as $checklistId) {
            $entriesPerChecklist[$checklistId] = rand(1, 3);
        }
        
        // Calculate total entries to create
        $totalEntries = array_sum($entriesPerChecklist);
        
        foreach ($checklistIds as $checklistId) {
            // Create multiple entries for this checklist
            for ($i = 0; $i < $entriesPerChecklist[$checklistId]; $i++) {
                // Generate status
                $status = $statusOptions[array_rand($statusOptions)];
                
                // Set dates based on status
                $createdAt = Carbon::now()->subDays(rand(1, 180));
                $componentDate = $createdAt->copy()->subDays(rand(0, 30));
                $updatedAt = $createdAt->copy()->addDays(rand(0, 30));
                $approvalDateTime = $status === 'active' ? 
                    $updatedAt->copy()->addDays(rand(1, 5)) : null;
                
                // Generate component status
                $componentStatus = $status === 'active' ? 'completed' : 
                    ($status === 'pending' ? 'pending' : 
                    ($status === 'rejected' ? 'failed' : 'inactive'));
                
                // Create the record
                ChecklistDisposalInstallation::create([
                    'checklist_id' => $checklistId,
                    
                    // Component information
                    'component_name' => $componentNames[array_rand($componentNames)],
                    'component_date' => $componentDate,
                    'component_scope_of_work' => $scopeOfWorkTemplates[array_rand($scopeOfWorkTemplates)],
                    'component_status' => $componentStatus,
                    
                    // System information
                    'status' => $status,
                    'prepared_by' => in_array($status, ['active', 'rejected', 'inactive']) ? 
                        $staffMembers[array_rand($staffMembers)] : null,
                    'verified_by' => in_array($status, ['active', 'rejected']) ? 
                        $staffMembers[array_rand($staffMembers)] : null,
                    'remarks' => $this->getRemarks($status, $componentStatus),
                    'approval_datetime' => $approvalDateTime,
                    
                    // Timestamps
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'deleted_at' => rand(1, 20) === 1 ? 
                        $updatedAt->copy()->addDays(rand(1, 30)) : null, // ~5% chance of being soft deleted
                ]);
            }
        }
    }
    
    /**
     * Get remarks based on status
     */
    private function getRemarks(string $status, string $componentStatus): ?string
    {
        // 30% chance of having no remarks
        if (rand(1, 100) <= 30) {
            return null;
        }
        
        $statusRemarks = [
            'active' => [
                'Installation completed successfully and functioning as expected.',
                'All components verified and operational.',
                'System meets or exceeds specifications.',
                'Performance testing completed with positive results.',
                'Documentation and training provided to staff.'
            ],
            'pending' => [
                'Installation scheduled for next maintenance window.',
                'Awaiting delivery of components.',
                'Permit approval in process.',
                'Tenant coordination required before proceeding.',
                'Pre-installation assessment scheduled.'
            ],
            'rejected' => [
                'Installation failed to meet code requirements.',
                'System performance below acceptable standards.',
                'Incorrect components installed.',
                'Safety concerns identified during inspection.',
                'Documentation incomplete or inaccurate.'
            ],
            'inactive' => [
                'System decommissioned due to obsolescence.',
                'Replaced by upgraded system.',
                'No longer required due to operational changes.',
                'Temporarily disabled for facility renovations.',
                'Pending removal and site restoration.'
            ]
        ];
        
        return $statusRemarks[$status][array_rand($statusRemarks[$status])];
    }
}